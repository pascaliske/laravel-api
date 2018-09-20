<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'path',
        'type',
        'author',
        'optimized'
    ];

    protected $casts = [
        'optimized' => 'boolean',
    ];

    /**
     * Get the user that uploaded the media file.
     */
    public function author()
    {
        return $this->belongsTo('App\Api\Models\User', 'id');
    }
}
