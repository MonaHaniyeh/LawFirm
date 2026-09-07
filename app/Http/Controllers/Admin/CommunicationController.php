<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseFile;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommunicationController extends Controller
{
    public function index(Request $request)
    {
        $cases = CaseFile::query()
            ->from('cases')
            ->with([
                'client',
                'lawyer',
                'messages' => function ($query) {
                    $query->latest('created_at')->limit(1);
                },
            ])
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->q;

                $query->where(function ($query) use ($search) {
                    $query->where(
                        'case_number',
                        'like',
                        "%{$search}%"
                    );
                });
            })
            ->withCount('messages')
            ->having('messages_count', '>', 0)
            ->orderByDesc(
                DB::raw(
                    '(SELECT MAX(created_at)
                     FROM messages
                     WHERE messages.case_id = cases.id)'
                )
            )
            ->paginate(20)
            ->withQueryString();

        return view('admin.communications.index', [
            'communications' => $cases,
        ]);
    }

    public function show(CaseFile $case)
    {
        $case->load([
            'client',
            'lawyer',
            'messages' => function ($query) {
                $query
                    ->with(['sender', 'receiver'])
                    ->oldest('created_at');
            },
        ]);

        return view('admin.communications.show', [
            'case' => $case,
            'communication' => $case,
        ]);
    }

    public function destroy(Message $message)
    {
        $caseId = $message->case_id;

        $message->delete();

        return back()
            ->with('status', 'Message removed.')
            ->with('case_id', $caseId);
    }
}