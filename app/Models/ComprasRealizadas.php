<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComprasRealizadas extends Model
{
    protected $table = 'compras_realizadas'; //nombre de la tabla, la bd ya fue mencionada en .env
    public $timestamps = false;
    public function productosComprados()
    {
        //significa que tiene "productos comprados" osea una relacion donde las "compras" tienen "productos comprados"
        return $this->hasMany(ProductosComprados::class, 'id_compra');
    }
}
