<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = ['title', 'description', 'path', 'components', 'published'];

    protected $casts = ['components' => 'array'];
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
