<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
     use HasFactory;

    protected $fillable = [
        'user_id',
        'prestataire_id',
        'note',
        'commentaire',
    ];

    // 🔗 Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prestataire()
    {
        return $this->belongsTo(Prestataire::class);
    }
    
}
