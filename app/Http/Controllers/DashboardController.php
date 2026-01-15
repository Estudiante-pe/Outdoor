<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ruta;
use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Pago;
use App\Models\Movilidad;
use App\Models\Guia;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:dashboard.ver')->only(['index']);
    }
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->hasRole('Usuario')) {
            // Redirige a la vista básica si solo tiene el rol "Usuario"
            return view('dashboard'); // asegúrate que esta vista exista en /resources/views/dashboard.blade.php
        }

        // 1. RUTAS
        $rutasActivas = Ruta::where('estado', 'Activo')->count();
        $rutasInactivas = Ruta::where('estado', 'Inactivo')->count();
        $precioRegularPromedio = Ruta::where('estado', 'Activo')->avg('precio_regular');
        $precioActualPromedio = Ruta::where('estado', 'Activo')->avg('precio_actual');

        // Rutas más vendidas
        $rutasVendidas = DB::table('reservas')
            ->join('fecha_disponibles', 'reservas.id_fecha', '=', 'fecha_disponibles.id_fecha')
            ->join('rutas', 'fecha_disponibles.id_ruta', '=', 'rutas.id_ruta')
            ->select('rutas.nombre_ruta', DB::raw('COUNT(reservas.id_reserva) as total_reservas'))
            ->groupBy('rutas.nombre_ruta')
            ->orderByDesc('total_reservas')
            ->limit(5)
            ->get();

        // Rutas con mayor ingreso
        $rutasConMasIngresos = DB::table('reservas')
            ->join('pagos', 'reservas.id_reserva', '=', 'pagos.id_reserva')
            ->join('fecha_disponibles', 'reservas.id_fecha', '=', 'fecha_disponibles.id_fecha')
            ->join('rutas', 'fecha_disponibles.id_ruta', '=', 'rutas.id_ruta')
            ->select('rutas.nombre_ruta', DB::raw('SUM(pagos.monto_pagado) as total_ingresos'))
            ->groupBy('rutas.nombre_ruta')
            ->orderByDesc('total_ingresos')
            ->limit(5)
            ->get();


        // 2. RESERVAS
        $reservasTotales = Reserva::count();
        $reservasPendientes = Reserva::where('estado', 'Pendiente')->count();
        $reservasPagadas = Reserva::where('estado', 'Pagado')->count();
        $reservasCanceladas = Reserva::where('estado', 'Cancelado')->count();

        $reservasPorMes = Reserva::selectRaw('MONTH(fecha_reserva) as mes, COUNT(*) as total')
            ->groupByRaw('MONTH(fecha_reserva)')
            ->orderByRaw('MONTH(fecha_reserva)')
            ->get();

        // 3. CLIENTES
        $clientesTotales = Cliente::count();

        $clientesConReservas = DB::table('reserva_clientes')->distinct('id_cliente')->count();

        $clientesPorMes = Cliente::selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->get();

        $clientesPorRegion = Cliente::select('region', DB::raw('COUNT(*) as total'))
            ->groupBy('region')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        // 4. MOVILIDAD Y GUÍAS
        $movilidadDisponible = Movilidad::where('estado', 'Disponible')->count();
        $movilidadOcupada = Movilidad::where('estado', 'Ocupado')->count();

        $guiasTotales = Guia::count(); // puedes expandir esto con disponibilidad por fecha si se modela

        // 5. PAGOS
        $ingresosTotales = Pago::sum('monto_pagado');

        $pagosPorMes = Pago::selectRaw('MONTH(fecha_pago) as mes, SUM(monto_pagado) as total')
            ->groupByRaw('MONTH(fecha_pago)')
            ->orderByRaw('MONTH(fecha_pago)')
            ->get();

        $metodosDePago = Pago::select('metodo_pago', DB::raw('COUNT(*) as total'))
            ->groupBy('metodo_pago')
            ->get();
        $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        /* SUMAS DE PAGOS */
        $pagosPorMetodoYMes = Pago::selectRaw('metodo_pago, MONTH(fecha_pago) as mes, SUM(monto_pagado) as total')
            ->groupBy('metodo_pago', DB::raw('MONTH(fecha_pago)'))
            ->orderBy('mes')
            ->get();

        $metodos = $pagosPorMetodoYMes->pluck('metodo_pago')->unique();


        $metodosDePagoTotales = Pago::select('metodo_pago', DB::raw('SUM(monto_pagado) as total'))
            ->groupBy('metodo_pago')
            ->get();


        return view('dashboard.index', compact(
            'rutasActivas',
            'rutasInactivas',
            'precioRegularPromedio',
            'precioActualPromedio',
            'rutasVendidas',
            'reservasTotales',
            'reservasPendientes',
            'reservasPagadas',
            'reservasCanceladas',
            'reservasPorMes',
            'clientesTotales',
            'clientesConReservas',
            'clientesPorMes',
            'clientesPorRegion',
            'movilidadDisponible',
            'movilidadOcupada',
            'guiasTotales',
            'ingresosTotales',
            'pagosPorMes',
            'metodosDePago',
            'meses',
            'rutasConMasIngresos',
            'pagosPorMetodoYMes',
            'metodos',
            'metodosDePagoTotales'
        ));
    }
}
