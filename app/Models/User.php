<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //nom au pluriel car un user peut poster plusieurs quacks
    //cardinalité 0,n
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    //nom au pluriel car un user peut poster plusieurs commentaires
    //cardinalité 0,n
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    //nom au singulier car 1 seul role en relation
    //cardinalité 1,1
    public function role()
    {
        return $this->belongTo(Role::class);
    }

    public function isAdmin()
    {
        //return $this-> role == "admin";
        return $this->role_id == 2;
    }

}
