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
        Schema::create('item_seccion_perfil_evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seccion_id');
            $table->unsignedBigInteger('item_id')->nullable();
            $table->unsignedBigInteger('competencia_id')->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();
            $table->foreign('seccion_id')->references('id')->on('seccion_perfil_evaluaciones')->cascadeOnDelete();
            $table->foreign('item_id')->references('id')->on('item_perfil_evaluaciones')->cascadeOnDelete();
            $table->foreign('competencia_id')->references('id')->on('competencias')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_seccion_perfil_evaluaciones');
    }
};
