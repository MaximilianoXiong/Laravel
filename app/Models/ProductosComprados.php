<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductosComprados extends Model
{
    protected $table = 'productos_comprados'; //nombre de la tabla, la bd ya fue mencionada en .env
    protected $fillable = ['id_producto', 'precio', 'cantidad', 'id_compra'];
    public $timestamps = false;

    public function compra()
    {
        //en relacion a... o mejor dicho, esto esta relacionado con... algo...
        //por asi decirlo, pertenece a una relacion
        return $this->belongsTo(ComprasRealizadas::class, 'id_compra');
    }

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'id_producto');
    }

}
