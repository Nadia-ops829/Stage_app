<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nom',
        'email',
        'adresse',
        'domaine',
        'telephone',
        'mot_de_passe',
    ];

    public function setMotDePasseAttribute($value)
    {
        $this->attributes['mot_de_passe'] = bcrypt($value);
    }


    // Une entreprise possède un utilisateur propriétaire
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Une entreprise possède plusieurs stages
    public function stages()
    {
        return $this->hasMany(Stage::class, 'entreprise_id');
    }

    // Une entreprise reçoit plusieurs candidatures via ses stages
    public function candidatures()
    {
        return $this->hasManyThrough(
            Candidature::class,  // Le modèle final
            Stage::class,        // Le modèle intermédiaire
            'entreprise_id',     // Clé étrangère sur la table stages
            'stage_id',          // Clé étrangère sur la table candidatures
            'id',                // Clé locale sur la table entreprises
            'id'                 // Clé locale sur la table stages
        );
    }


}
