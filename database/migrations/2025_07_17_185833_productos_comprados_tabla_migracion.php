<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos_comprados', function (Blueprint $tabla) {
            $tabla->id();

            //crea la columna 'id_producto' como unsignedBigInteger (para clave foranea)
            $tabla->unsignedBigInteger('id_producto');
            //crea la columna 'id_compra' como unsignedBigInteger
            $tabla->unsignedBigInteger('id_compra');

            $tabla->integer('cantidad');
            $tabla->double('precio');

            //establezco las relaciones, pero compras_realizadas para borrar en cascada
            $tabla->foreign('id_producto')->references('id')->on('producto');
            $tabla->foreign('id_compra')->references('id')->on('compras_realizadas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
