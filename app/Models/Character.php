<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $fillable = 
    [
        'firstname', 
        'lastname', 
        'description', 
        'aptitude', 
        'role',
        'classe_id', 
        
    ]; 

    public function classe()
    {
        return $this->belongsTo(Classe::class); 
    }
}
