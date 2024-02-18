<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_type_id',
        'title',
        'description',
        'duration',
        'mondatory',
        'happy',
        'meaning',
        'date',
    ];
}
