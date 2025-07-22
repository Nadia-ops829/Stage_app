<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'email',
        'adresse',
        'domaine',
        'telephone',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }

    public function offres()
    {
        return $this->hasMany(Offre::class);
    }

    public function stages()
    {
        return $this->hasMany(Stage::class);
    }

   


}
