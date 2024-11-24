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
        Schema::create('aprobaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evaluacion_id');
            $table->tinyInteger('estado')->default(0);
            $table->string('brechas_criticas')->nullable();
            $table->decimal('nota', 3, 2)->nullable();
            $table->decimal('porcentaje', 5, 2)->nullable();
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
        Schema::dropIfExists('aprobaciones');
    }
};
