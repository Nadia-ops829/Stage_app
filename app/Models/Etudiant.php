<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'niveau',
        'specialite',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec les stages via les candidatures acceptées
    public function stages()
    {
        return $this->belongsToMany(Stage::class, 'candidatures', 'etudiant_id', 'stage_id')
            ->wherePivot('statut', 'acceptee')
            ->withTimestamps();
    }
}
