<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Credito extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'creditos';
    protected $fillable = ['cliente_id', 'adeudo'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function abonos()
    {
        return $this->hasMany(Abono::class);
    }

    public function getSaldoPendienteAttribute()
    {
        $totalAbonado = $this->abonos->sum('abono');
        return $this->adeudo - $totalAbonado;
    }
}
