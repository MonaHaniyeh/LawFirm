<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\CaseFile;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use App\Events\UserTyping;

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
     * Display the complete conversation.
     */
    public function show(Message $message)
    {
        $lawyer = Auth::user();

        $case = $message->case;

        if (!$case) {
            abort(404, 'Case not found.');
        }

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

        return view(
            'lawyer.messages.show',
            compact(
                'message',
                'case',
                'messages'
            )
        );
    }

    /**
     * Display the reply page.
     */
    public function replyForm(CaseFile $case)
    {
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
        | Get client
        |--------------------------------------------------------------------------
        */

        $case->load('client');

        /*
        |--------------------------------------------------------------------------
        | Get previous messages
        |--------------------------------------------------------------------------
        */

        $messages = Message::with([
            'sender',
        ])
            ->where('case_id', $case->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view(
            'lawyer.messages.reply',
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
        $lawyer = Auth::user();

        /*
    |--------------------------------------------------------------------------
    | Security
    |--------------------------------------------------------------------------
    |
    | The lawyer can only reply to their own cases.
    |
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
    | Broadcast message
    |--------------------------------------------------------------------------
    */

        $message->load('sender');

        broadcast(new MessageSent($message))->toOthers();

        /*
    |--------------------------------------------------------------------------
    | Return to conversation
    |--------------------------------------------------------------------------
    */

        return redirect()
            ->route(
                'lawyer.messages.show',
                $message
            )
            ->with(
                'status',
                'Your reply has been sent successfully.'
            );
    }

    public function typing(Request $request)
    {
        $lawyer = Auth::user();

        $data = $request->validate([
            'case_id' => ['required', 'integer'],
            'typing' => ['required', 'boolean'],
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
