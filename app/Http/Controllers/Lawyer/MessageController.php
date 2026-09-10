<?php

namespace App\Http\Controllers\Lawyer;

use App\Events\MessageSent;
use App\Events\UserTyping;
use App\Http\Controllers\Controller;
use App\Models\CaseFile;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display all conversations for the logged-in lawyer.
     */
    public function index()
    {
        /** @var \App\Models\User $lawyer */
        $lawyer = Auth::user();

        $threads = $lawyer->casesAsLawyer()
            ->with([
                'client',
                'messages' => function ($query) {
                    $query->latest('created_at');
                },
            ])
            ->get()
            ->filter(function (CaseFile $case) {
                return $case->messages->isNotEmpty();
            })
            ->map(function (CaseFile $case) {

                $latestMessage = $case->messages->first();

                return (object) [
                    'case' => $case,
                    'case_id' => $case->id,
                    'case_number' => $case->case_number,
                    'client' => $case->client,
                    'latestMessage' => $latestMessage,
                    'created_at' => $latestMessage?->created_at
                        ?? $case->created_at,
                ];
            })
            ->sortByDesc('created_at')
            ->values();

        return view(
            'lawyer.messages.index',
            compact('threads')
        );
    }


    /**
     * Display the complete conversation for a case.
     */
    public function show(CaseFile $case)
    {
        /** @var \App\Models\User $lawyer */
        $lawyer = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Security
        |--------------------------------------------------------------------------
        |
        | A lawyer can only view conversations belonging
        | to their own cases.
        |
        */

        abort_unless(
            (int) $case->lawyer_id === (int) $lawyer->id,
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Load client
        |--------------------------------------------------------------------------
        */

        $case->load('client');


        /*
        |--------------------------------------------------------------------------
        | Get all messages for this case
        |--------------------------------------------------------------------------
        */

        $messages = Message::with([
            'sender',
            'receiver',
        ])
            ->where('case_id', $case->id)
            ->orderBy('created_at', 'asc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Mark received messages as read
        |--------------------------------------------------------------------------
        */

        Message::where('case_id', $case->id)
            ->where('receiver_id', $lawyer->id)
            ->where('is_new', true)
            ->update([
                'is_new' => false,
            ]);


        /*
        |--------------------------------------------------------------------------
        | Show conversation + reply form
        |--------------------------------------------------------------------------
        */

        return view(
            'lawyer.messages.show',
            compact(
                'case',
                'messages'
            )
        );
    }


    /**
     * Send a reply to the client.
     */
    public function reply(
        Request $request,
        CaseFile $case
    ) {
        /** @var \App\Models\User $lawyer */
        $lawyer = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | Security
        |--------------------------------------------------------------------------
        */

        abort_unless(
            (int) $case->lawyer_id === (int) $lawyer->id,
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Validate
        |--------------------------------------------------------------------------
        */

        $data = $request->validate([
            'content' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Make sure a client exists
        |--------------------------------------------------------------------------
        */

        if (!$case->client_id) {
            return back()
                ->withErrors([
                    'content' => 'This case does not have a client assigned.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Create message
        |--------------------------------------------------------------------------
        */

        $message = Message::create([
            'case_id' => $case->id,
            'sender_id' => $lawyer->id,
            'receiver_id' => $case->client_id,
            'subject' => null,
            'content' => trim($data['content']),
            'is_new' => true,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Load relationships for broadcasting
        |--------------------------------------------------------------------------
        */

        $message->load([
            'sender',
            'receiver',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Broadcast message
        |--------------------------------------------------------------------------
        */

        broadcast(
            new MessageSent($message)
        )->toOthers();


        /*
        |--------------------------------------------------------------------------
        | Return to the case conversation
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'lawyer.messages.show',
                $case
            )
            ->with(
                'status',
                'Your reply has been sent successfully.'
            );
    }


    /**
     * Broadcast lawyer typing status.
     */
    public function typing(Request $request)
    {
        /** @var \App\Models\User $lawyer */
        $lawyer = Auth::user();

        $data = $request->validate([
            'case_id' => [
                'required',
                'integer',
                'exists:case_files,id',
            ],
            'typing' => [
                'required',
                'boolean',
            ],
        ]);

        $case = CaseFile::findOrFail($data['case_id']);

        abort_unless(
            (int) $case->lawyer_id === (int) $lawyer->id,
            403
        );

        UserTyping::dispatch(
            caseId: (int) $case->id,
            userId: (int) $lawyer->id,
            userName: $lawyer->name,
            role: 'lawyer',
            typing: (bool) $data['typing']
        );

        return response()->json([
            'success' => true,
        ]);
    }
}
