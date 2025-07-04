<?php

namespace App\Models;

use App\EventStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'introduction',
        'greeting',
        'date',
        'start_at',
        'end_at',
        'status',
        'hashtag',
        'prayer',
        'design_id',
        'package_id',
        'organiser_id',
        'music_id',
        'frame_id',
        'youtube_music_url',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status' => EventStatus::class,
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function design()
    {
        return $this->belongsTo(Design::class);
    }

    public function organiser()
    {
        return $this->belongsTo(Organiser::class);
    }

    public function music()
    {
        return $this->belongsTo(Music::class);
    }

    public function frame()
    {
        return $this->belongsTo(Frame::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function tentatives()
    {
        return $this->hasMany(Tentative::class);
    }

    public function gifts()
    {
        return $this->has(Gift::class);
    }

    public function guestSettings()
    {
        return $this->has(GuestSetting::class);
    }

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function orders()
    {
        return $this->has(Order::class);
    }
}
