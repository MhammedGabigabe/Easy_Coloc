<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dette extends Model
{
    protected $fillable = [
        'membership_id', 
        'depense_id', 
        'montant_a_payer', 
        'date_paiement', 
        'statut_dette'];

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    } 
    
    public function depense()
    {
        return $this->belongsTo(Depense::class);
    }
}
