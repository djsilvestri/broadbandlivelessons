<?php

namespace App;


use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
// use Spatie\MediaLibrary\InteractsWithMedia; 

class Channel extends Model implements HasMedia
{

    use HasMediaTrait; 
/**
     * A channel belongs to a user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 
     */
    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        if ($this->media->first()) {
            return $this->media->first()->getFullUrl('thumb');
        }

        return null;
    }
    /**
     * 
     * Check if a user is authorized to edit this model instance
     * 
     * @return boolean
     * 
     */
    public function editable()
    {
        if (! auth()-> check()) return false;

        return $this->user_id === auth()->user()->id;
    }

    /**
     * Register the media conversions.
     * 
     * @return null
     * 
     */

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
        ->width(100)
        ->height(100);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
