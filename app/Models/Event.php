<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model 
{
    use HasFactory;

    protected $casts = [  // ARRAY DOS ITEMS DO EVENTO
        'items' => 'array'
    ];

    protected $dates = ['date']; 

    protected $guarded = []; // NECESSARIO PARA ATUALIZA 

    public function user(){  // RELACAO DE N PRA 1
        return $this->belongsTo(User::class);
    }

    public function users(){ // RELACAO DE N PRA N
        return $this->belongsToMany(User::class);
    }
}
