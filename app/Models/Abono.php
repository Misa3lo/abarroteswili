<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Abono extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'abonos';
    protected $fillable = ['credito_id', 'abono', 'fecha_hora'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($abono) {
            $abono->fecha_hora = now();
        });
    }

    public function credito()
    {
        return $this->belongsTo(Credito::class);
    }
}
