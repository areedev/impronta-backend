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
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('candidato_id');
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('faena_id');
            $table->unsignedBigInteger('area_id');
            $table->unsignedBigInteger('perfil_evaluacion_id');
            $table->string('cargo')->nullable();
            $table->string('evaluador_asignado')->nullable();
            $table->date('fecha_solicitud')->nullable();
            $table->date('fecha_ejecucion')->nullable();
            $table->date('fecha_emision')->nullable();
            $table->string('certificado')->nullable();
            $table->string('equipo')->nullable();
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->year('year')->nullable();
            $table->string('condiciones')->nullable();
            $table->unsignedBigInteger('usuario_creador')->nullable();
            $table->tinyInteger('estado')->default(0);
            $table->timestamps();
            $table->foreign('candidato_id')->references('id')->on('candidatos')->cascadeOnDelete();
            $table->foreign('empresa_id')->references('id')->on('empresas')->cascadeOnDelete();
            $table->foreign('faena_id')->references('id')->on('faenas')->cascadeOnDelete();
            $table->foreign('area_id')->references('id')->on('areas')->cascadeOnDelete();
            $table->foreign('perfil_evaluacion_id')->references('id')->on('perfil_evaluaciones')->cascadeOnDelete();
            $table->foreign('usuario_creador')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluaciones');
    }
};
