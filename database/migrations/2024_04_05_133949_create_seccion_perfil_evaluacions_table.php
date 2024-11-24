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
        Schema::create('seccion_perfil_evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('perfil_evaluacion_id');
            $table->string('nombre')->nullable();
            $table->tinyInteger('orden')->default(1);
            $table->timestamps();
            $table->foreign('perfil_evaluacion_id')->references('id')->on('perfil_evaluaciones')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seccion_perfil_evaluaciones');
    }
};
