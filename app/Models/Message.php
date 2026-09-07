<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_id',
        'sender_id',
        'receiver_id',
        'subject',
        'content',
        'is_new',
    ];

    protected $casts = [
        'is_new' => 'boolean',
    ];

    /**
     * The case this message belongs to.
     */
    public function case()
    {
        return $this->belongsTo(
            CaseFile::class,
            'case_id'
        );
    }

    /**
     * The user who sent the message.
     */
    public function sender()
    {
        return $this->belongsTo(
            User::class,
            'sender_id'
        );
    }

    /**
     * The user who receives the message.
     */
    public function receiver()
    {
        return $this->belongsTo(
            User::class,
            'receiver_id'
        );
    }
}