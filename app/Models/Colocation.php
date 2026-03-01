<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Colocation extends Model
{
    protected $fillable = [
        'nom_coloc',
        'status',
        'owner_id',
        'date_creation',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function membresActifs()
    {
        return $this->belongsToMany(User::class, 'memberships', 'colocation_id', 'membre_id')
                    ->wherePivot('left_at', null);
    }

    public function depenses()
    {
        return $this->hasMany(Depense::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Categorie::class, 'categorie_colocation');
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

}
