<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    protected $table = 'metodo_pago';
    protected $primaryKey = 'id';
    protected $fillable = ['descripcion'];
    public $timestamps = false;

    // No usar SoftDeletes si la tabla no tiene deleted_at
}
