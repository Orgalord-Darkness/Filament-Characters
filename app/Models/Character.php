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
        'grade_id', 
        
    ]; 

    public function classe()
    {
        return $this->belongsTo(Classe::class); 
    }
    public function grade()
    {
        return $this->belongsTo(Grade::class); 
    }

    public static function genererCouleurAleatoire($limite = 100) {
        $couleurs = array();
        for ($j = 0; $j < $limite; $j++) {
            $couleur = '#';
            for ($i = 0; $i < 6; $i++) {
                $couleur .= dechex(rand(0, 15));
            }
            $couleurs[] = $couleur;
        }
        return $couleurs;
    }
}
