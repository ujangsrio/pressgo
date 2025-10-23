<?php
// app/Models/Attendance.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'date',
        'check_in',
        'check_out',
        'notes',
        'status'
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
