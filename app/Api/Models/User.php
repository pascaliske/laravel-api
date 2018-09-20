<?php

namespace App\Api\Models;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'firstName',
        'lastName',
        'email',
        'password',
        'activated',
        'confirmed',
    ];

    protected $casts = [
        'activated' => 'boolean',
        'confirmed' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * Get the pages the user has created.
     */
    public function pages()
    {
        return $this->hasMany('App\Api\Models\Page', 'author');
    }

    /**
     * Get the media the user has uploaded.
     */
    public function media()
    {
        return $this->hasMany('App\Api\Models\Media', 'author');
    }

    public function scopeActivated($query)
    {
        return $query->where('activated', true);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('confirmed', true);
    }

    public function scopeCanLogin($query, $email)
    {
        return $query->where('activated', true)->where('confirmed', true)->where('email', $email);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
