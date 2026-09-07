<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AccountController;

// Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LawyerController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\BillingController;
use App\Http\Controllers\Admin\CommunicationController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminCaseController;
use App\Http\Controllers\Admin\AdminAppointmentController;

// Accountant
use App\Http\Controllers\Accountant\DashboardController as AccountantDashboardController;
use App\Http\Controllers\Accountant\InvoiceController;

// Lawyer
use App\Http\Controllers\Lawyer\DashboardController as LawyerDashboardController;
use App\Http\Controllers\Lawyer\AppointmentController;
use App\Http\Controllers\Lawyer\CaseController;
use App\Http\Controllers\Lawyer\MessageController;

// Client
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\AppointmentController as ClientAppointmentController;
use App\Http\Controllers\Client\CaseController as ClientCaseController;


/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
|
*/

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            AdminDashboardController::class,
            'index'
        ])->name('dashboard');

        // users
        Route::get('/users', [AdminUserController::class, 'index'])
            ->name('users.index');

        Route::get('/users/create', [AdminUserController::class, 'create'])
            ->name('users.create');

        Route::post('/users', [AdminUserController::class, 'store'])
            ->name('users.store');

        Route::get('/users/{user}', [AdminUserController::class, 'show'])
            ->name('users.show');

        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])
            ->name('users.edit');

        Route::put('/users/{user}', [AdminUserController::class, 'update'])
            ->name('users.update');

        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])
            ->name('users.destroy');

        // Deleted Users
        Route::get('/users-deleted', [AdminUserController::class, 'deleted'])
            ->name('users.deleted');

        Route::patch('/users-deleted/{id}/restore', [AdminUserController::class, 'restore'])
            ->name('users.restore');

        Route::delete('/users-deleted/{id}/force-delete', [AdminUserController::class, 'forceDelete'])
            ->name('users.forceDelete');

        //cases
        Route::get('/cases', [
            AdminCaseController::class,
            'index'
        ])->name('cases.index');

        Route::get('/cases/{case}', [
            AdminCaseController::class,
            'show'
        ])->name('cases.show');

        //appointment
        Route::get('/appointments', [
            AdminAppointmentController::class,
            'index'
        ])->name('appointments.index');

        Route::get('/appointments/{appointment}', [
            AdminAppointmentController::class,
            'show'
        ])->name('appointments.show');


        /*
        |--------------------------------------------------------------------------
        | Lawyers
        |--------------------------------------------------------------------------
        */

        Route::resource('lawyers', LawyerController::class);

        Route::patch('/lawyers/{lawyer}/billing-rate', [
            BillingController::class,
            'updateRate'
        ])->name('lawyers.billing-rate');


        /*
        |--------------------------------------------------------------------------
        | Clients
        |--------------------------------------------------------------------------
        */

        Route::get('/clients', [
            ClientController::class,
            'index'
        ])->name('clients.index');

        Route::get('/clients/{client}', [
            ClientController::class,
            'show'
        ])->name('clients.show');

        Route::patch('/clients/{client}/ban', [
            ClientController::class,
            'ban'
        ])->name('clients.ban');

        Route::patch('/clients/{client}/unban', [
            ClientController::class,
            'unban'
        ])->name('clients.unban');


        /*
        |--------------------------------------------------------------------------
        | Billing
        |--------------------------------------------------------------------------
        */

        Route::get('/billing', [
            BillingController::class,
            'index'
        ])->name('billing.index');

        Route::get('/invoices/{invoice}', [
            BillingController::class,
            'showInvoice'
        ])->name('billing.show');


        /*
        |--------------------------------------------------------------------------
        | Messages / Communications
        |--------------------------------------------------------------------------
        */

        Route::get('/messages', [
            CommunicationController::class,
            'index'
        ])->name('communication.index');

        Route::get('/messages/{case}', [
            CommunicationController::class,
            'show'
        ])->name('communication.show');

        Route::delete('/messages/{message}', [
            CommunicationController::class,
            'destroy'
        ])->name('communication.destroy');


        /*
        |--------------------------------------------------------------------------
        | Account Settings
        |--------------------------------------------------------------------------
        */

        Route::get('/settings', [
            AccountController::class,
            'settings'
        ])->name('settings.edit');

        Route::put('/settings', [
            AccountController::class,
            'updateSettings'
        ])->name('settings.update');


        /*
        |--------------------------------------------------------------------------
        | Change Password
        |--------------------------------------------------------------------------
        */

        Route::get('/password', [
            AccountController::class,
            'password'
        ])->name('password.edit');

        Route::put('/password', [
            AccountController::class,
            'updatePassword'
        ])->name('password.update');
    });



/*
|--------------------------------------------------------------------------
| LAWYER ROUTES
|--------------------------------------------------------------------------
|
*/

Route::middleware(['auth', 'verified', 'role:lawyer'])
    ->prefix('lawyer')
    ->name('lawyer.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Lawyer Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            LawyerDashboardController::class,
            'index'
        ])->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Appointments
        |--------------------------------------------------------------------------
        */

        Route::get('/appointments', [
            AppointmentController::class,
            'index'
        ])->name('appointments.index');

        Route::get('/appointments/schedule', [
            AppointmentController::class,
            'schedule'
        ])->name('appointments.schedule');

        Route::post('/appointments', [
            AppointmentController::class,
            'store'
        ])->name('appointments.store');


        /*
        |--------------------------------------------------------------------------
        | Appointment Respond
        |--------------------------------------------------------------------------
        */

        // Prevent direct GET access to the respond URL
        Route::get('/appointments/{appointment}/respond', function () {
            return redirect()->route('lawyer.appointments.index');
        })->name('appointments.respond.get');

        // Approve / Reject appointment
        Route::post('/appointments/{appointment}/respond', [
            AppointmentController::class,
            'respond'
        ])->name('appointments.respond');


        /*
        |--------------------------------------------------------------------------
        | Cases
        |--------------------------------------------------------------------------
        */

        Route::get('/cases', [
            CaseController::class,
            'index'
        ])->name('cases.index');

        Route::get('/cases/{case}', [
            CaseController::class,
            'show'
        ])->name('cases.show');

        Route::get('/cases/{case}/edit', [
            CaseController::class,
            'edit'
        ])->name('cases.edit');

        Route::put('/cases/{case}', [
            CaseController::class,
            'update'
        ])->name('cases.update');

        Route::post('/cases/{case}/documents', [
            CaseController::class,
            'storeDocument'
        ])->name('cases.documents.store');

        Route::get('/cases/{case}/documents/{document}/download', [
            CaseController::class,
            'downloadDocument'
        ])->name('cases.documents.download');

        Route::post('/cases/{case}/messages', [
            CaseController::class,
            'storeMessage'
        ])->name('cases.messages.store');


        /*
        |--------------------------------------------------------------------------
        | Messages
        |--------------------------------------------------------------------------
        */

        Route::get('/messages', [
            MessageController::class,
            'index'
        ])->name('messages.index');

        Route::get('/messages/{message}', [
            MessageController::class,
            'show'
        ])->name('messages.show');

        Route::get('/messages/{case}/reply', [
            MessageController::class,
            'replyForm'
        ])->name('messages.reply.form');

        Route::post('/messages/{case}/reply', [
            MessageController::class,
            'reply'
        ])->name('messages.reply');


        /*
        |--------------------------------------------------------------------------
        | Account Settings
        |--------------------------------------------------------------------------
        */

        Route::get('/settings', [
            AccountController::class,
            'settings'
        ])->name('settings.edit');

        Route::put('/settings', [
            AccountController::class,
            'updateSettings'
        ])->name('settings.update');


        /*
        |--------------------------------------------------------------------------
        | Password
        |--------------------------------------------------------------------------
        */

        Route::get('/password', [
            AccountController::class,
            'password'
        ])->name('password.edit');

        Route::put('/password', [
            AccountController::class,
            'updatePassword'
        ])->name('password.update');
    });



/*
|--------------------------------------------------------------------------
| CLIENT ROUTES
|--------------------------------------------------------------------------
|
*/

Route::middleware(['auth', 'verified', 'role:client'])
    ->prefix('client')
    ->name('client.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            ClientDashboardController::class,
            'index'
        ])->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Appointments
        |--------------------------------------------------------------------------
        */

        Route::get('/appointments', [
            ClientAppointmentController::class,
            'index'
        ])->name('appointments.index');

        Route::post('/appointments', [
            ClientAppointmentController::class,
            'store'
        ])->name('appointments.store');


        /*
        |--------------------------------------------------------------------------
        | Cases
        |--------------------------------------------------------------------------
        */

        Route::get('/cases', [
            ClientCaseController::class,
            'index'
        ])->name('cases.index');

        Route::get('/cases/create', [
            ClientCaseController::class,
            'create'
        ])->name('cases.create');

        Route::post('/cases', [
            ClientCaseController::class,
            'store'
        ])->name('cases.store');

        Route::get('/cases/{case}', [
            ClientCaseController::class,
            'show'
        ])->name('cases.show');


        /*
        |--------------------------------------------------------------------------
        | Case Documents
        |--------------------------------------------------------------------------
        */

        Route::post('/cases/{case}/documents', [
            ClientCaseController::class,
            'uploadDocument'
        ])->name('cases.documents.store');

        Route::get('/cases/{case}/documents/{document}', [
            ClientCaseController::class,
            'downloadDocument'
        ])->name('cases.documents.download');


        /*
        |--------------------------------------------------------------------------
        | Case Messages
        |--------------------------------------------------------------------------
        */

        Route::post('/cases/{case}/messages', [
            ClientCaseController::class,
            'sendMessage'
        ])->name('cases.messages.store');


        /*
        |--------------------------------------------------------------------------
        | Messages
        |--------------------------------------------------------------------------
        */

        Route::get('/messages', [
            MessageController::class,
            'index'
        ])->name('messages.index');


        /*
        |--------------------------------------------------------------------------
        | Account Settings
        |--------------------------------------------------------------------------
        */

        Route::get('/settings', [
            AccountController::class,
            'settings'
        ])->name('settings.edit');

        Route::put('/settings', [
            AccountController::class,
            'updateSettings'
        ])->name('settings.update');


        /*
        |--------------------------------------------------------------------------
        | Change Password
        |--------------------------------------------------------------------------
        */

        Route::get('/password', [
            AccountController::class,
            'password'
        ])->name('password.edit');

        Route::put('/password', [
            AccountController::class,
            'updatePassword'
        ])->name('password.update');
    });



/*
|--------------------------------------------------------------------------
| ACCOUNTANT ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:accountant'])
    ->prefix('accountant')
    ->name('accountant.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            AccountantDashboardController::class,
            'index'
        ])->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Invoices
        |--------------------------------------------------------------------------
        */

        Route::resource('invoices', InvoiceController::class)
            ->except(['destroy']);


        /*
        |--------------------------------------------------------------------------
        | Billing
        |--------------------------------------------------------------------------
        */

        Route::get('/billing', function () {
            return view('accountant.billing.index');
        })->name('billing.index');


        /*
        |--------------------------------------------------------------------------
        | Account Settings
        |--------------------------------------------------------------------------
        */

        Route::get('/settings', [
            AccountController::class,
            'settings'
        ])->name('settings.edit');

        Route::put('/settings', [
            AccountController::class,
            'updateSettings'
        ])->name('settings.update');


        /*
        |--------------------------------------------------------------------------
        | Change Password
        |--------------------------------------------------------------------------
        */

        Route::get('/password', [
            AccountController::class,
            'password'
        ])->name('password.edit');

        Route::put('/password', [
            AccountController::class,
            'updatePassword'
        ])->name('password.update');
    });

require __DIR__ . '/auth.php';
