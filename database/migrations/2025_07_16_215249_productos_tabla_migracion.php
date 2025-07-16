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
        Schema::create('producto', function (Blueprint $tabla) {
            $tabla->id();
            $tabla->string('nombre');
            $tabla->string('codigo');
            $tabla->integer('stock')->nullable();
            $tabla->integer('stock_min')->nullable();
            $tabla->double('precio');
            $tabla->double('oferta')->nullable();
            $tabla->string('tipo_oferta')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //si existe, borra la tabla y la recrea
        //Schema::dropIfExists('producto');
    }
};
