<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapport extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'stage_id',
        'statut',
        'fichier',
        // Ajoute d'autres champs si besoin
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
