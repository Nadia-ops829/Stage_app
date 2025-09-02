<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'role',
        'password',
        'telephone',
        'niveau',
        'specialite',
        'adresse',
        'domaine',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    

    
    public function isAdmin()
    {
        return $this->role === 'admin';
    }


    public function isEtudiant()
    {
        return $this->role === 'etudiant';
    }

    public function isEntreprise()
    {
        return $this->role === 'entreprise';
    }


    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }


    public function stages()
    {
        return $this->hasMany(Stage::class, 'etudiant_id'); 
    }
    


}
