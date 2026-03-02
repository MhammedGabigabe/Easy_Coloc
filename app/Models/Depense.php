<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'titre', 
        'montant', 
        'createur_id', 
        'colocation_id', 
        'categorie_id', 
        'date_depense'];

    public function payeur()
    {
        return $this->belongsTo(User::class, 'createur_id');
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function dettes()
    {
        return $this->hasMany(Dette::class);
    }
}
