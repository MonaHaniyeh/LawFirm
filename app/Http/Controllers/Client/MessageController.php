<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CaseFile;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;

class MessageController extends Controller
{
    /**
     * Display the client's message conversations.
     */
    public function index()
    {
        /** @var \App\Models\User $client */
        $client = Auth::user();

        $threads = $client->casesAsClient()
            ->with([
                'lawyer',
                'messages' => function ($query) {
                    $query
                        ->with(['sender', 'receiver'])
                        ->latest('created_at');
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
                    'lawyer' => $case->lawyer,
                    'latestMessage' => $latestMessage,
                    'created_at' => $latestMessage?->created_at
                        ?? $case->created_at,
                ];
            })
            ->sortByDesc('created_at')
            ->values();

        return view(
            'client.messages.index',
            compact('threads')
        );
    }


    /**
     * Display a complete conversation.
     */
    public function show(Message $message)
    {
        /** @var \App\Models\User $client */
        $client = Auth::user();

        $case = $message->case;

        /*
        |--------------------------------------------------------------------------
        | Make sure the message belongs to a case owned by this client.
        |--------------------------------------------------------------------------
        */

        if (!$case) {
            abort(404, 'Case not found.');
        }

        abort_unless(
            (int) $case->client_id === (int) $client->id,
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Load the conversation.
        |--------------------------------------------------------------------------
        */

        $case->load([
            'lawyer',
            'client',
        ]);

        $messages = Message::query()
            ->with([
                'sender',
                'receiver',
            ])
            ->where('case_id', $case->id)
            ->orderBy('created_at', 'asc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Mark lawyer messages as read.
        |--------------------------------------------------------------------------
        */

        Message::query()
            ->where('case_id', $case->id)
            ->where('receiver_id', $client->id)
            ->where('is_new', true)
            ->update([
                'is_new' => false,
            ]);


        return view(
            'client.messages.show',
            compact(
                'message',
                'case',
                'messages'
            )
        );
    }


    /**
     * Send a reply to the lawyer.
     */
    public function reply(
        Request $request,
        CaseFile $case
    ) {
        /** @var \App\Models\User $client */
        $client = Auth::user();

        /*
    |--------------------------------------------------------------------------
    | Security: client must own the case.
    |--------------------------------------------------------------------------
    */

        abort_unless(
            (int) $case->client_id === (int) $client->id,
            403
        );

        /*
    |--------------------------------------------------------------------------
    | Validate message.
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
    | Create message.
    |--------------------------------------------------------------------------
    */

        $message = Message::create([
            'case_id' => $case->id,
            'sender_id' => $client->id,
            'receiver_id' => $case->lawyer_id,
            'subject' => null,
            'content' => trim($data['content']),
            'is_new' => true,
        ]);

        /*
    |--------------------------------------------------------------------------
    | Broadcast the message in real time.
    |--------------------------------------------------------------------------
    */

        $message->load('sender');

        broadcast(new MessageSent($message))->toOthers();

        /*
    |--------------------------------------------------------------------------
    | Return to conversation.
    |--------------------------------------------------------------------------
    */

        return redirect()
            ->route(
                'client.messages.show',
                $message
            )
            ->with(
                'status',
                'Your message has been sent successfully.'
            );
    }
}
