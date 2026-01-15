<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovilidadReporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:reporte.ver')->only(['index', 'show']);
    }
    public function index()
    {
        return view('movilidad_reporte.index');
    }

    // PASO 1: Fecha → Rutas
    public function rutasPorFecha(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date'
        ]);

        $rutas = DB::table('rutas')
            ->join('fecha_disponibles', 'rutas.id_ruta', '=', 'fecha_disponibles.id_ruta')
            ->where('fecha_disponibles.fecha', $request->fecha)
            ->select('rutas.id_ruta', 'rutas.nombre_ruta')
            ->distinct()
            ->get();

        return response()->json($rutas);
    }

    // PASO 2: Ruta → Movilidades
    public function movilidadesPorRuta(Request $request)
    {
        // Validamos que lleguen ambos
        $request->validate([
            'id_ruta' => 'required|integer',
            'fecha'   => 'required|date'
        ]);

        $movilidades = DB::table('movilidads as m')
            ->join('reserva_movilidads as rm', 'm.id_movilidad', '=', 'rm.id_movilidad')
            ->join('reservas as r', 'rm.id_reserva', '=', 'r.id_reserva')
            ->join('fecha_disponibles as f', 'r.id_fecha', '=', 'f.id_fecha')
            ->where('f.id_ruta', $request->id_ruta)
            ->where('f.fecha', $request->fecha) // Filtro por fecha para ser exactos
            ->select('m.id_movilidad', 'm.ruta', 'm.conductor')
            ->distinct()
            ->get();

        return response()->json($movilidades);
    }

    // PASO 3: Movilidad → Manifiesto
    public function manifiestoPorMovilidad(Request $request)
{
    $request->validate([
        'id_movilidad' => 'required|integer'
    ]);

    $data = DB::table('reservas as r')
        ->join('reserva_movilidads as rm', 'r.id_reserva', '=', 'rm.id_reserva')
        ->join('fecha_disponibles as f', 'r.id_fecha', '=', 'f.id_fecha')
        ->join('rutas as ru', 'f.id_ruta', '=', 'ru.id_ruta')
        ->join('reserva_clientes as rc', 'r.id_reserva', '=', 'rc.id_reserva')
        ->join('clientes as c', 'rc.id_cliente', '=', 'c.id_cliente')
        ->where('rm.id_movilidad', $request->id_movilidad)
        ->select(
            'ru.nombre_ruta',
            DB::raw("CONCAT(c.nombre,' ',c.apellido) as cliente"),
            'c.telefono',
            'r.estado',
            'r.saldo'
        )
        ->get();

    // 👉 Guías de la movilidad
    $guias = DB::table('movilidad_guias as mg')
        ->join('guias as g', 'mg.id_guia', '=', 'g.id_guia')
        ->where('mg.id_movilidad', $request->id_movilidad)
        ->select(DB::raw("CONCAT(g.nombre,' ',g.apellido) as nombre"))
        ->pluck('nombre')
        ->implode(', ');

    return response()->json([
        'guias' => $guias ?: 'Sin guía asignado',
        'data'  => $data
    ]);
}

}
