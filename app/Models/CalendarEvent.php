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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function event_type()
    {
        return $this->hasMany(EventType::class, 'event_type_id', 'id');
    }
}
