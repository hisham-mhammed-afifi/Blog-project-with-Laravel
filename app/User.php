<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image', 'name', 'email', 'password', 'about', 'gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * delete user image from storage
     *
     * @return void
     */
    public function deletePhoto()
    {
        Storage::disk('public')->delete($this->image);
    }

    /**
     * Undocumented function
     *
     * @return object
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * check if the user is admin
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->role === "admin";
    }
}
