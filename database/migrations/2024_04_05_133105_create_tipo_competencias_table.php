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
        Schema::create('tipo_competencias', function (Blueprint $table) {
            $table->id();
            $table->string('abreviatura')->unique();
            $table->string('nombre')->nullable();
            $table->timestamps();
        });
        Artisan::call('db:seed', array('--class' => 'TipoCompetenciaSeeder'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_competencias');
    }
};
