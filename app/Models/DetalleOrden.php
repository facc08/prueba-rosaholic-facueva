<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOrden extends Model
{
    use HasFactory;

    protected $table = 'detalle_orden';
    protected $primaryKey = 'id';

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
        'id_orden', 'descripcion_producto', 'cantidad' ,'estado'
    ];
}
