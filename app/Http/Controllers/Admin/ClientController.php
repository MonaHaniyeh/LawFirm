<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display all clients.
     */
    public function index(Request $request)
    {
        $search = $request->input('q');

        $clients = User::where('role', 'client')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->withCount('casesAsClient')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Display a client.
     */
    public function show(User $client)
    {
        abort_unless($client->role === 'client', 404);

        $client->load([
            'casesAsClient.lawyer',
            'appointmentsAsClient.lawyer',
        ]);

        return view('admin.clients.show', compact('client'));
    }

    /**
     * Ban a client.
     */
    public function ban(User $client)
    {
        abort_unless($client->role === 'client', 404);

        $client->update([
            'status' => 'banned',
        ]);

        return back()->with(
            'status',
            $client->name . ' has been banned.'
        );
    }

    /**
     * Unban a client.
     */
    public function unban(User $client)
    {
        abort_unless($client->role === 'client', 404);

        $client->update([
            'status' => 'active',
        ]);

        return back()->with(
            'status',
            $client->name . ' has been reinstated.'
        );
    }
}