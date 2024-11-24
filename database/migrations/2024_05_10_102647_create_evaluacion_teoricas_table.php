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
        Schema::create('evaluaciones_teoricas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evaluacion_id');
            $table->integer('preguntas');
            $table->integer('preguntas_buenas');
            $table->string('archivo')->nullable();
            $table->decimal('nota', 3, 2);
            $table->timestamps();
            $table->foreign('evaluacion_id')->references('id')->on('evaluaciones')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluaciones_teoricas');
    }
};
