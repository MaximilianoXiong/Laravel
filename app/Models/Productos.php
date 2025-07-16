<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table = 'producto'; //nombre de la tabla, la bd ya fue mencionada en .env
    protected $fillable = ['nombre', 'codigo', 'stock', 'stock_min', 'precio', 'oferta', 'tipo_oferta'];
    public $timestamps = false;

    public function productosComprados()
    {
        return $this->hasMany(ProductosComprados::class, 'id');
    }

}
