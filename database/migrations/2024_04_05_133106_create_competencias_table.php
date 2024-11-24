<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_competencia_id');
            $table->string('llave')->nullable();
            $table->text('nombre');
            $table->text('definicion')->nullable();
            $table->string('proyecto')->nullable();
            $table->string('alcance')->nullable();
            $table->timestamps();
        });
        Artisan::call('db:seed', array('--class' => 'CompetenciaSeeder'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competencias');
    }
};
