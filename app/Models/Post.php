<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'tags',
        'user_id',
        'image',
    ];
    // charge automatiquement l'utilisateur à chaque fois que je récupère un message
    protected $with = ['user'];

    //nom de la fonction au singulier car 1 seul user en relation
    //cardinalité 1,1
    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    //nom de la fonction au pluriel car un mesage peut regrouper plusieurs commentaires
    //cardinalité 0,n
    public function comments ()
    {
        return $this->hasMany(Comment::class);
    }
}
