<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{

public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:auditoria.ver')->only(['index', 'show']);
    }
    // Vista General (La que ya tenías)
    public function index(Request $request)
    {
        $query = Activity::with('causer')->latest();

        // Filtro por Tipo de Actividad (log_name)
        if ($request->filled('tipo')) {
            $query->where('log_name', $request->tipo);
        }

        // Filtro por Usuario
        if ($request->filled('usuario')) {
            $query->where('causer_id', $request->usuario);
        }

        // Filtro por Rango de Fechas
        if ($request->filled('desde')) {
            $query->whereDate('created_at', '>=', $request->desde);
        }
        if ($request->filled('hasta')) {
            $query->whereDate('created_at', '<=', $request->hasta);
        }

        $activities = $query->paginate(20)->withQueryString();
        
        // Necesitamos la lista de usuarios para el filtro
        $usuarios = \App\Models\User::all();

        return view('logs.index', compact('activities', 'usuarios'));
    }

}