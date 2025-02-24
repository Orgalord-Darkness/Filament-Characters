<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Classe extends Model
{
    // Une classe de personnage 

    protected $fillable = 
    [
        'name', 
        'description', 
    ]; 

    public function characters()
    {
        return $this->hasMany(Character::class);
    }
}
