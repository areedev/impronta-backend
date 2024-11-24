<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultado_evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evaluacion_id');
            $table->unsignedBigInteger('item_id');
            $table->decimal('nota', 3, 2);
            $table->decimal('porcentaje', 5, 2);
            $table->timestamps();
            $table->foreign('evaluacion_id')->references('id')->on('evaluaciones')->cascadeOnDelete();
            $table->foreign('item_id')->references('id')->on('item_seccion_perfil_evaluaciones')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resultado_evaluaciones');
    }
};
