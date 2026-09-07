<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CaseFile;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display all message conversations for the logged-in client.
     */
    public function index()
    {/** @var \App\Models\User $client */
    
        $client = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Get the client's cases
        |--------------------------------------------------------------------------
        */

        $threads = $client->casesAsClient()
            ->with([
                'lawyer',
                'messages' => function ($query) {
                    $query->latest('created_at');
                },
            ])
            ->get()

            /*
            |--------------------------------------------------------------------------
            | Only cases that have messages
            |--------------------------------------------------------------------------
            */

            ->filter(function (CaseFile $case) {
                return $case->messages->isNotEmpty();
            })

            /*
            |--------------------------------------------------------------------------
            | Convert each case into a conversation thread
            |--------------------------------------------------------------------------
            */

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

            /*
            |--------------------------------------------------------------------------
            | Newest conversation first
            |--------------------------------------------------------------------------
            */

            ->sortByDesc('created_at')
            ->values();

        return view(
            'client.messages.index',
            compact('threads')
        );
    }
}