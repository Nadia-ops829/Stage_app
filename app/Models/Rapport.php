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
        'fichier',
        'commentaire_etudiant',
        'commentaire_entreprise',
        'statut',
        'date_depot',
        'date_validation'
    ];

    protected $dates = [
        'date_depot',
        'date_validation',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'date_depot' => 'date',
        'date_validation' => 'date',
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
