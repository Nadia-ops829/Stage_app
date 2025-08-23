<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'stage_id',
        'statut',
        'lettre_motivation',
        'cv_path',
        'date_candidature',
        'date_reponse',
        'commentaire_entreprise'
    ];

    protected $casts = [
        'date_candidature' => 'datetime',
        'date_reponse' => 'datetime'
    ];

    // Relation avec l'étudiant
    public function etudiant()
    {
        return $this->belongsTo(User::class, 'etudiant_id');
    }

    // Relation avec le stage
    public function stage()
    {
        return $this->belongsTo(Stage::class, 'stage_id');
    }

    // Scope pour les candidatures en attente
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopeAcceptees($query)
    {
        return $query->where('statut', 'acceptee');
    }

    public function scopeRefusees($query)
    {
        return $query->where('statut', 'refusee');
    }
}
