<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    protected $fillable = [
        'entreprise_id',
        'titre',
        'description',
        'domaine',
        'niveau_requis',
        'duree',
        'lieu',
        'remuneration',
        'statut',
        'date_debut',
        'date_fin',
        'nombre_places',
        'competences_requises'
    ];

    protected $casts = [
        'competences_requises' => 'array',
        'date_debut' => 'date',
        'date_fin' => 'date',
        'remuneration' => 'decimal:2'
    ];

    // Relation avec l'entreprise
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'entreprise_id');
    }

    // Relation avec les candidatures
    public function candidatures()
    {
        return $this->hasMany(Candidature::class, 'stage_id');
    }

    // Scope pour les stages actifs
    public function scopeActifs($query)
    {
        return $query->where('statut', 'active');
    }

    // Vérifier si le stage est complet
    public function isComplet()
    {
        return $this->candidatures()->count() >= $this->nombre_places;
    }

    // Nombre de places restantes
    public function getPlacesRestantes()
    {
        return max(0, $this->nombre_places - $this->candidatures()->count());
    }
}
