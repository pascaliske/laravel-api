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
        return $this->belongsTo('App\Api\Models\User', 'author');
    }

    public function scopeImages($query)
    {
        return $query->where('type', 'like', '%image%');
    }

    public function getOriginalPath()
    {
        return sprintf('%s/%s', storage_path('app'), $this->path);
    }

    public function getOptimizedPath()
    {
        $info = pathinfo($this->path);
        return sprintf('%s/%s/%s.webp', storage_path('app'), $info['dirname'], $info['filename']);
    }
}
