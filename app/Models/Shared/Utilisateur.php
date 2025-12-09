<?php

namespace App\Models\Shared;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use SoftDeletes, Notifiable;

    // ✅ Nom correct de la table
    protected $table = 'utilisateurs';
    
    // ✅ Clé primaire
    protected $primaryKey = 'idUser';
    
    // ✅ Timestamps Laravel
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // ✅ Champs fillable
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'telephone',
        'statut',
        'role',
        'note',
        'photo',
        'nbrAvis',
        'dateNaissance',
        'idAdmin'
    ];

    // ✅ Champs cachés (pour la sécurité)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ✅ Cast des attributs
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'dateNaissance' => 'date',
        'note' => 'float',
        'nbrAvis' => 'integer',
    ];

    // Relations
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'idAdmin', 'idAdmin');
    }

    public function intervenant()
    {
        return $this->hasOne(Intervenant::class, 'idIntervenant', 'idUser');
    }

    public function localisations()
    {
        return $this->hasMany(Localisation::class, 'idUser', 'idUser');
    }

    public function demandesClient()
    {
        return $this->hasMany(DemandesIntervention::class, 'idClient', 'idUser');
    }

    public function feedbacksRecus()
    {
        return $this->hasMany(Feedback::class, 'idCible', 'idUser');
    }

    public function feedbacksEnvoyes()
    {
        return $this->hasMany(Feedback::class, 'idAuteur', 'idUser');
    }

    public function reclamationsRecues()
    {
        return $this->hasMany(Reclamation::class, 'idCible', 'idUser');
    }

    public function reclamationsEnvoyees()
    {
        return $this->hasMany(Reclamation::class, 'idAuteur', 'idUser');
    }
}