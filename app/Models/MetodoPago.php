<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MetodoPago extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'metodo_pago';
    protected $fillable = ['descripcion'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'metodo_pago_id');
    }

    public function getCantidadTicketsAttribute()
    {
        return $this->tickets->count();
    }
}
