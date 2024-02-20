<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //nom au pluriel car un role peut regrouper plusieurs uers
    //cardinalité 1,n
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
