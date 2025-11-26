<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'personas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'apaterno',
        'amaterno',
        'telefono',
        'direccion'
    ];

    protected $dates = ['deleted_at'];

    // Relación con Cliente (una persona puede ser un cliente)
    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'persona_id');
    }

    // Relación con Usuario (una persona puede ser un usuario del sistema)
    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'persona_id');
    }

    // Accesor para el nombre completo
    public function getNombreCompletoAttribute()
    {
        $nombreCompleto = $this->nombre . ' ' . $this->apaterno;

        if (!empty($this->amaterno)) {
            $nombreCompleto .= ' ' . $this->amaterno;
        }

        return $nombreCompleto;
    }

    // Accesor para nombre y apellido paterno (formato corto)
    public function getNombreCortoAttribute()
    {
        return $this->nombre . ' ' . $this->apaterno;
    }

    // Accesor para iniciales
    public function getInicialesAttribute()
    {
        $iniciales = substr($this->nombre, 0, 1) . substr($this->apaterno, 0, 1);

        if (!empty($this->amaterno)) {
            $iniciales .= substr($this->amaterno, 0, 1);
        }

        return strtoupper($iniciales);
    }

    // Accesor para verificar si es cliente
    public function getEsClienteAttribute()
    {
        return $this->cliente()->exists();
    }

    // Accesor para verificar si es usuario del sistema
    public function getEsUsuarioAttribute()
    {
        return $this->usuario()->exists();
    }

    // Accesor para obtener el límite de crédito (si es cliente)
    public function getLimiteCreditoAttribute()
    {
        return $this->cliente ? $this->cliente->limite_credito : null;
    }

    // Accesor para obtener el rol (si es usuario)
    public function getRolAttribute()
    {
        return $this->usuario ? $this->usuario->rol : null;
    }

    // Scope para búsqueda por nombre
    public function scopePorNombre($query, $nombre)
    {
        return $query->where('nombre', 'like', "%{$nombre}%")
            ->orWhere('apaterno', 'like', "%{$nombre}%")
            ->orWhere('amaterno', 'like', "%{$nombre}%");
    }

    // Scope para búsqueda por teléfono
    public function scopePorTelefono($query, $telefono)
    {
        return $query->where('telefono', 'like', "%{$telefono}%");
    }

    // Scope para personas que son clientes
    public function scopeClientes($query)
    {
        return $query->whereHas('cliente');
    }

    // Scope para personas que son usuarios del sistema
    public function scopeUsuarios($query)
    {
        return $query->whereHas('usuario');
    }

    // Scope para personas que no son clientes
    public function scopeNoClientes($query)
    {
        return $query->whereDoesntHave('cliente');
    }

    // Scope para personas que no son usuarios
    public function scopeNoUsuarios($query)
    {
        return $query->whereDoesntHave('usuario');
    }

    // Scope para personas con dirección
    public function scopeConDireccion($query)
    {
        return $query->whereNotNull('direccion')->where('direccion', '!=', '');
    }

    // Método para crear persona y cliente en una sola operación
    public static function crearConCliente($datosPersona, $limiteCredito = 0)
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($datosPersona, $limiteCredito) {
            // Crear la persona
            $persona = self::create($datosPersona);

            // Crear el cliente asociado
            if ($limiteCredito >= 0) {
                $persona->cliente()->create([
                    'limite_credito' => $limiteCredito
                ]);
            }

            return $persona;
        });
    }

    // Método para crear persona y usuario en una sola operación
    public static function crearConUsuario($datosPersona, $datosUsuario)
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($datosPersona, $datosUsuario) {
            // Crear la persona
            $persona = self::create($datosPersona);

            // Crear el usuario asociado
            $persona->usuario()->create([
                'usuario' => $datosUsuario['usuario'],
                'password' => \Illuminate\Support\Facades\Hash::make($datosUsuario['password']),
                'rol' => $datosUsuario['rol'] ?? 'empleado'
            ]);

            return $persona;
        });
    }

    // Método para convertir persona en cliente
    public function convertirEnCliente($limiteCredito = 0)
    {
        if ($this->es_cliente) {
            throw new \Exception('Esta persona ya es cliente');
        }

        return $this->cliente()->create([
            'limite_credito' => $limiteCredito
        ]);
    }

    // Método para convertir persona en usuario
    public function convertirEnUsuario($usuario, $password, $rol = 'empleado')
    {
        if ($this->es_usuario) {
            throw new \Exception('Esta persona ya es usuario del sistema');
        }

        return $this->usuario()->create([
            'usuario' => $usuario,
            'password' => \Illuminate\Support\Facades\Hash::make($password),
            'rol' => $rol
        ]);
    }

    // Método para obtener información combinada de persona y cliente
    public function getInfoClienteAttribute()
    {
        if (!$this->es_cliente) {
            return null;
        }

        return [
            'persona' => $this,
            'cliente' => $this->cliente,
            'creditos_activos' => $this->cliente->creditosActivos(),
            'total_adeudado' => $this->cliente->total_adeudado
        ];
    }

    // Método para obtener información combinada de persona y usuario
    public function getInfoUsuarioAttribute()
    {
        if (!$this->es_usuario) {
            return null;
        }

        return [
            'persona' => $this,
            'usuario' => $this->usuario,
            'total_tickets' => $this->usuario->total_tickets,
            'ventas_totales' => $this->usuario->ventas_totales
        ];
    }

    // Método para validar formato de teléfono (simple)
    public function getTelefonoValidoAttribute()
    {
        if (empty($this->telefono)) {
            return false;
        }

        // Validación simple de teléfono (10 dígitos)
        return preg_match('/^\d{10}$/', preg_replace('/\D/', '', $this->telefono));
    }

    // Método para formatear teléfono
    public function getTelefonoFormateadoAttribute()
    {
        if (empty($this->telefono)) {
            return 'No disponible';
        }

        $telefono = preg_replace('/\D/', '', $this->telefono);

        if (strlen($telefono) === 10) {
            return '(' . substr($telefono, 0, 3) . ') ' .
                substr($telefono, 3, 3) . '-' .
                substr($telefono, 6, 4);
        }

        return $this->telefono;
    }
}
