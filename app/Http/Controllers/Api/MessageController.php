<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\CaseFile;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MessageResource;

class MessageController extends Controller
{
    /**
     * Get all messages for a case.
     */
    public function index(CaseFile $case): JsonResponse
    {
        $user = Auth::user();

        $this->authorizeCaseAccess($user->id, $case);

        $messages = Message::with([
            'sender:id,name',
            'receiver:id,name',
        ])
            ->where('case_id', $case->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'case' => [
                'id' => $case->id,
                'case_number' => $case->case_number,
                'title' => $case->title,
            ],
            'messages' => MessageResource::collection($messages),
        ]);
    }

    /**
     * Send a new message.
     */
    public function store(
        Request $request,
        CaseFile $case
    ): JsonResponse {
        $user = Auth::user();

        $this->authorizeCaseAccess($user->id, $case);

        $data = $request->validate([
            'content' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);

        /*
         * Determine the other participant.
         */
        if ((int) $user->id === (int) $case->client_id) {
            $receiverId = $case->lawyer_id;
        } else {
            $receiverId = $case->client_id;
        }

        if (!$receiverId) {
            return response()->json([
                'success' => false,
                'message' => 'This case does not have another participant.',
            ], 422);
        }

        $message = Message::create([
            'case_id' => $case->id,
            'sender_id' => $user->id,
            'receiver_id' => $receiverId,
            'subject' => null,
            'content' => trim($data['content']),
            'is_new' => true,
        ]);

        $message->load([
            'sender:id,name',
            'receiver:id,name',
        ]);

        /*
         * Broadcast the message in realtime.
         */
        broadcast(
            new MessageSent($message)
        )->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully.',
            'data' => new MessageResource($message),
        ], 201);
    }

    /**
     * Mark messages received by the authenticated user as read.
     */
    public function markAsRead(CaseFile $case): JsonResponse
    {
        $user = Auth::user();

        $this->authorizeCaseAccess($user->id, $case);

        $updated = Message::where('case_id', $case->id)
            ->where('receiver_id', $user->id)
            ->where('is_new', true)
            ->update([
                'is_new' => false,
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Messages marked as read.',
            'updated' => $updated,
        ]);
    }

    /**
     * Make sure the authenticated user belongs to the case.
     */
    private function authorizeCaseAccess(
        int $userId,
        CaseFile $case
    ): void {
        abort_unless(
            (int) $case->client_id === $userId ||
            (int) $case->lawyer_id === $userId,
            403
        );
    }
}