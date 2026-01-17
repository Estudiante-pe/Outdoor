<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Ruta extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'rutas';
    protected $primaryKey = 'id_ruta'; 
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'nombre_ruta',
        'descripcion_general',
        'tipo',
        'precio_regular',
        'descuento',
        'precio_actual',
        'hora_salida',
        'dificultad',
        'estado',
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleRuta::class, 'id_ruta');
    }

    public function fechasDisponibles()
    {
        return $this->hasMany(FechaDisponible::class, 'id_ruta');
    }

    public function lugaresVisitar()
    {
        return $this->hasMany(LugarVisitar::class, 'id_ruta');
    }

    public function serviciosIncluidos()
    {
        return $this->hasMany(ServicioIncluido::class, 'id_ruta');
    }

    public function imagenes()
    {
        return $this->hasMany(Imagen::class, 'id_ruta');
    }

    public function getHoraSalida12Attribute()
    {
    if (!$this->hora_salida) {
        return null;
    }
    try {
        // Quita microsegundos si existen
        $hora = explode('.', $this->hora_salida)[0]; 
        return Carbon::parse($hora)->format('h:i A');
    } catch (\Exception $e) {
        return $this->hora_salida; // fallback, por si algo falla
    }
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable() // Registra todos los campos en $fillable
            ->logOnlyDirty() // Solo registra si algo cambió realmente
            ->dontSubmitEmptyLogs() // No crea logs si no hubo cambios
            ->useLogName('Rutas'); // Nombre de la categoría del log
    }
    
}
