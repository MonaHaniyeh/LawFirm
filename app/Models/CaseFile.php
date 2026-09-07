<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CaseFile extends Model
{
    use HasFactory, Notifiable;

    /**
     * Database table.
     */
    protected $table = 'cases';

    /**
     * Mass assignable fields.
     */
    protected $fillable = [
        'case_number',
        'client_id',
        'lawyer_id',
        'case_type',
        'description',
        'status',
        'start_date',
        'end_date',
    ];

    /**
     * Attribute casting.
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * The client who owns this case.
     */
    public function client()
    {
        return $this->belongsTo(
            User::class,
            'client_id'
        );
    }

    /**
     * The lawyer assigned to this case.
     */
    public function lawyer()
    {
        return $this->belongsTo(
            User::class,
            'lawyer_id'
        );
    }

    /**
     * Documents belonging to this case.
     */
    public function documents()
    {
        return $this->hasMany(
            Document::class,
            'case_id'
        );
    }

    /**
     * Messages belonging to this case.
     *
     * One case = one conversation.
     */
    public function messages()
    {
        return $this->hasMany(
            Message::class,
            'case_id'
        );
    }

    /**
     * Appointments belonging to this case.
     */
    public function appointments()
    {
        return $this->hasMany(
            Appointment::class,
            'case_id'
        );
    }

    /**
     * Invoices belonging to this case.
     */
    public function invoices()
    {
        return $this->hasMany(
            Invoice::class,
            'case_id'
        );
    }
}