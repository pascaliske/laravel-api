<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = ['title', 'description', 'path', 'components', 'author', 'published'];

    protected $casts = ['components' => 'array'];
}
