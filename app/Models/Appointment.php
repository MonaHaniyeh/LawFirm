<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'lawyer_id',
        'case_id',
        'appointment_date',
        'appointment_time',
        'meeting_location',
        'note',
        'status',
        'response',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
        'is_new' => 'boolean',
    ];

    /**
     * Client who owns the appointment.
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Lawyer assigned to the appointment.
     */
    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id');
    }

    /**
     * Case associated with the appointment.
     */
    public function case()
    {
        return $this->belongsTo(CaseFile::class, 'case_id');
    }
}
