<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Abono extends Model
{
    use SoftDeletes;

    // Asumiendo que la tabla se llama 'abonos'
    protected $table = 'abonos';

    protected $fillable = [
        'credito_id',
        'abono',
        'fecha_hora', // La columna que estás usando para la fecha del pago
    ];

    // Indica que 'fecha_hora' y los timestamps de Laravel deben ser objetos de fecha
    protected $casts = [
        'fecha_hora' => 'datetime',
    ];

    /**
     * Define la relación inversa: Un abono pertenece a un único Crédito.
     */
    public function credito()
    {
        return $this->belongsTo(Credito::class, 'credito_id');
    }
}
