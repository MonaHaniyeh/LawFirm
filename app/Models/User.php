<?php

namespace App\Models;

use App\Notifications\CustomVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
 

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable , SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'language',
        'specialization',
        'license_number',
        'experience_years',
        'status',
        'bio',
        'billing_rate',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'billing_rate' => 'decimal:2',
        ];
    }

    /**
     * Send the custom LAWFIRM email verification notification.
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new CustomVerifyEmail());
    }

    /**
     * Send the custom LAWFIRM password reset notification.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Check if the user is a client.
     */
    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    /**
     * Check if the user is a lawyer.
     */
    public function isLawyer(): bool
    {
        return $this->role === 'lawyer';
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is an accountant.
     */
    public function isAccountant(): bool
    {
        return $this->role === 'accountant';
    }

    /**
     * Cases where this user is the client.
     */
    public function casesAsClient()
    {
        return $this->hasMany(CaseFile::class, 'client_id');
    }

    /**
     * Cases where this user is the lawyer.
     */
    public function casesAsLawyer()
    {
        return $this->hasMany(CaseFile::class, 'lawyer_id');
    }

    /**
     * Appointments where this user is the client.
     */
    public function appointmentsAsClient()
    {
        return $this->hasMany(Appointment::class, 'client_id');
    }

    /**
     * Appointments where this user is the lawyer.
     */
    public function appointmentsAsLawyer()
    {
        return $this->hasMany(Appointment::class, 'lawyer_id');
    }

    /**
     * Messages sent by this user.
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Messages received by this user.
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Documents uploaded by this user.
     */
    public function uploadedDocuments()
    {
        return $this->hasMany(Document::class, 'uploaded_by');
    }

    /**
     * Invoices where this user is the client.
     */
    public function invoicesAsClient()
    {
        return $this->hasMany(Invoice::class, 'client_id');
    }

    /**
     * Invoices where this user is the accountant.
     */
    public function invoicesAsAccountant()
    {
        return $this->hasMany(Invoice::class, 'accountant_id');
    }
}