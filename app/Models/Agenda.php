<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        'date',
        'time',
        'start_time',
        'end_time',
        'activity',
        'institution',
        'division',
        'person_in_charge',
        'is_archived'
    ];

    protected $casts = [
        'date' => 'date',
        'is_archived' => 'boolean'
    ];
}
