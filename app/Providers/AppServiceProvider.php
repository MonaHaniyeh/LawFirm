<?php

namespace App\Providers;

use App\Models\CaseFile;
use App\Models\User;
use App\Policies\CaseFilePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
{
    Gate::policy(CaseFile::class, CaseFilePolicy::class);
}
}
