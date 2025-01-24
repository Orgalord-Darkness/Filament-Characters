<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = 
    [
        'libelle', 
        'abilitation', 
        'description', 
        'color', 
        'text_color', 
    ]; 

    public function characters()
    {
        return $this->hasMany(Character::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->text_color = $model->darkenColor($model->color, 50); // Assombrir de 50%
        });

        static::updating(function ($model) {
            $model->text_color = $model->darkenColor($model->color, 50); // Assombrir de 50%
        });
    }

    function darkenColor($hex, $percent) {
        // Convertir le hex en RGB
        $hex = str_replace("#", "", $hex);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    
        // Calculer la nouvelle valeur RGB
        $r = max(0, min(255, $r - ($r * $percent / 100)));
        $g = max(0, min(255, $g - ($g * $percent / 100)));
        $b = max(0, min(255, $b - ($b * $percent / 100)));
    
        // Convertir le RGB en hex
        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }
    
    
}
