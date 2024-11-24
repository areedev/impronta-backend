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
        Schema::create('criterio_desempeño_interno_evaluacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evaluacion_id');
            $table->unsignedBigInteger('criterio_id');
            $table->decimal('nota', 3, 2);
            $table->text('comentarios')->nullable();
            $table->timestamps();
            $table->foreign('evaluacion_id')->references('evaluacion_id')->on('resultado_evaluaciones')->cascadeOnDelete();
            $table->foreign('criterio_id')->references('id')->on('criterio_desempeño_internos')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('criterio_desempeño_interno_evaluacions');
    }
};
