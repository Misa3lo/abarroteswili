<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clientes';
    protected $fillable = ['persona_id', 'limite_credito'];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function creditos()
    {
        return $this->hasMany(Credito::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
