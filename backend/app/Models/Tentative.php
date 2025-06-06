<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tentative extends Model
{
    /** @use HasFactory<\Database\Factories\TentativeFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'detail',
        'date',
        'event_id',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
