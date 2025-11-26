<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index()
    {
        // Mostrar usuarios con información de persona
        $usuarios = Usuario::with('persona')
            ->orderBy('usuario')
            ->paginate(15);

        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        // Obtener personas que no tienen usuario asociado
        $personas = Persona::doesntHave('usuario')
            ->orderBy('nombre')
            ->get();

        return view('usuarios.create', compact('personas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'persona_id' => 'required|exists:personas,id|unique:usuarios,persona_id',
            'usuario' => 'required|string|max:50|unique:usuarios,usuario',
            'password' => 'required|string|min:6|confirmed',
            'rol' => 'required|in:administrador,empleado'
        ]);

        try {
            DB::beginTransaction();

            // Crear el usuario
            Usuario::create([
                'persona_id' => $request->persona_id,
                'usuario' => $request->usuario,
                'password' => Hash::make($request->password),
                'rol' => $request->rol
            ]);

            DB::commit();

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario creado correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al crear el usuario: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Usuario $usuario)
    {
        $usuario->load(['persona', 'tickets.cliente.persona']);

        // Estadísticas del usuario
        $totalTickets = $usuario->total_tickets;
        $ventasTotales = $usuario->ventas_totales;
        $ventasEsteMes = $usuario->ventasEsteMes();

        // Tickets recientes
        $ticketsRecientes = $usuario->tickets()
            ->with(['cliente.persona', 'metodoPago'])
            ->orderBy('fecha_hora', 'desc')
            ->take(10)
            ->get();

        return view('usuarios.show', compact(
            'usuario',
            'totalTickets',
            'ventasTotales',
            'ventasEsteMes',
            'ticketsRecientes'
        ));
    }

    public function edit(Usuario $usuario)
    {
        $usuario->load('persona');

        // Obtener todas las personas para poder cambiar si es necesario
        $personas = Persona::orderBy('nombre')->get();

        return view('usuarios.edit', compact('usuario', 'personas'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'persona_id' => 'required|exists:personas,id|unique:usuarios,persona_id,' . $usuario->id,
            'usuario' => 'required|string|max:50|unique:usuarios,usuario,' . $usuario->id,
            'rol' => 'required|in:administrador,empleado',
            'password' => 'nullable|string|min:6|confirmed'
        ]);

        try {
            DB::beginTransaction();

            $data = [
                'persona_id' => $request->persona_id,
                'usuario' => $request->usuario,
                'rol' => $request->rol
            ];

            // Actualizar password solo si se proporcionó uno nuevo
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $usuario->update($data);

            DB::commit();

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario actualizado correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al actualizar el usuario: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Usuario $usuario)
    {
        // Verificar que no tenga tickets antes de eliminar
        if ($usuario->tickets()->count() > 0) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No se puede eliminar el usuario porque tiene tickets asociados');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente');
    }

    // Método para buscar usuarios
    public function search(Request $request)
    {
        $search = $request->get('search');

        $usuarios = Usuario::with('persona')
            ->porUsuario($search)
            ->orWherePorNombre($search)
            ->orderBy('usuario')
            ->paginate(15);

        return view('usuarios.index', compact('usuarios', 'search'));
    }

    // Método para administradores
    public function administradores()
    {
        $usuarios = Usuario::with('persona')
            ->administradores()
            ->orderBy('usuario')
            ->paginate(15);

        return view('usuarios.administradores', compact('usuarios'));
    }

    // Método para empleados
    public function empleados()
    {
        $usuarios = Usuario::with('persona')
            ->empleados()
            ->orderBy('usuario')
            ->paginate(15);

        return view('usuarios.empleados', compact('usuarios'));
    }

    // Método para cambiar contraseña
    public function cambiarPassword(Request $request, Usuario $usuario)
    {
        $request->validate([
            'password_actual' => 'required|string',
            'password' => 'required|string|min:6|confirmed'
        ]);

        // Verificar contraseña actual
        if (!Hash::check($request->password_actual, $usuario->password)) {
            return back()->withErrors(['password_actual' => 'La contraseña actual es incorrecta']);
        }

        $usuario->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('usuarios.show', $usuario)
            ->with('success', 'Contraseña actualizada correctamente');
    }

    // Método para perfil del usuario actual
    public function perfil()
    {
        // Aquí iría la lógica para obtener el usuario autenticado
        // Por ahora usaremos el primer usuario como ejemplo
        $usuario = Usuario::first();

        if (!$usuario) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No hay usuarios en el sistema');
        }

        return $this->show($usuario);
    }

    // Método para estadísticas de usuarios
    public function estadisticas()
    {
        $totalUsuarios = Usuario::count();
        $totalAdministradores = Usuario::administradores()->count();
        $totalEmpleados = Usuario::empleados()->count();

        $usuariosActivos = Usuario::activos()->count();
        $usuariosInactivos = Usuario::onlyTrashed()->count();

        // Top vendedores (usuarios con más ventas)
        $topVendedores = Usuario::with('persona')
            ->withCount('tickets')
            ->withSum('tickets', 'total')
            ->orderBy('tickets_sum_total', 'desc')
            ->take(10)
            ->get();

        return view('usuarios.estadisticas', compact(
            'totalUsuarios',
            'totalAdministradores',
            'totalEmpleados',
            'usuariosActivos',
            'usuariosInactivos',
            'topVendedores'
        ));
    }

    // Método para reporte de actividad de usuarios
    public function reporteActividad(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', now()->subDays(30)->format('Y-m-d'));
        $fechaFin = $request->get('fecha_fin', now()->format('Y-m-d'));

        $usuarios = Usuario::with(['persona', 'tickets' => function($query) use ($fechaInicio, $fechaFin) {
            $query->whereBetween('fecha_hora', [$fechaInicio, $fechaFin]);
        }])
            ->withCount(['tickets' => function($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('fecha_hora', [$fechaInicio, $fechaFin]);
            }])
            ->withSum(['tickets' => function($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('fecha_hora', [$fechaInicio, $fechaFin]);
            }], 'total')
            ->having('tickets_count', '>', 0)
            ->orderBy('tickets_sum_total', 'desc')
            ->get();

        return view('usuarios.reporte-actividad', compact('usuarios', 'fechaInicio', 'fechaFin'));
    }
}
