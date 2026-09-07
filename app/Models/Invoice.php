<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Invoice extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'case_id',
        'client_id',
        'accountant_id',
        'amount',
        'status',
        'description',
        'due_date',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'paid_at' => 'datetime',
    ];

    /**
     * Case associated with the invoice.
     */
    public function case()
    {
        return $this->belongsTo(CaseFile::class, 'case_id');
    }

    /**
     * Client responsible for the invoice.
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Accountant assigned to the invoice.
     */
    public function accountant()
    {
        return $this->belongsTo(User::class, 'accountant_id');
    }
}