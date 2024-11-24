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
        Schema::create('perfil_evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->integer('aprobacion')->nullable();
            $table->unsignedBigInteger('usuario_creador')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('perfil_evaluaciones');
    }
};
