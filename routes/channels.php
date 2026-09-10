<?php

use App\Models\CaseFile;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('case.{caseId}', function ($user, $caseId) {

    $case = CaseFile::find($caseId);

    if (! $case) {
        return false;
    }

    return (int) $user->id === (int) $case->client_id
        || (int) $user->id === (int) $case->lawyer_id
        || $user->role === 'admin';
});
