<?php

namespace App\Policies;

use App\Models\CaseFile;
use App\Models\User;

class CaseFilePolicy
{

    public function before(User $user, string $ability): ?bool
    {
        return $user->role === 'admin' ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['client', 'lawyer'])
            && $user->status !== 'banned';
    }


    public function view(User $user, CaseFile $case): bool
    {
        return $user->id === $case->client_id
            || $user->id === $case->lawyer_id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'client' && $user->status !== 'banned';
    }

    public function update(User $user, CaseFile $case): bool
    {
        return $user->id === $case->lawyer_id;
    }

    public function delete(User $user, CaseFile $case): bool
    {
        return false;
    }

    public function participate(User $user, CaseFile $case): bool
    {
        return $user->id === $case->client_id
            || $user->id === $case->lawyer_id;
    }

    public function restore(User $user, CaseFile $case): bool
    {
        return false;
    }

    public function forceDelete(User $user, CaseFile $case): bool
    {
        return false;
    }
}
