<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'event_id',
        'date',
        'number',
        'diff'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
