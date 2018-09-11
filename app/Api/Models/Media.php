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
    protected $fillable = ['title', 'description', 'path', 'type', 'author', 'optimized'];
}
