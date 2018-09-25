<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'title',
        'path',
        'components',
        'author',
        'published',
    ];

    protected $casts = [
        'components' => 'array',
        'published' => 'boolean',
    ];

    /**
     * Get the user that created the page.
     */
    public function author()
    {
        return $this->belongsTo('App\Api\Models\User', 'id');
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }
}
