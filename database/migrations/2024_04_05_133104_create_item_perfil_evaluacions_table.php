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
        Schema::create('item_perfil_evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedBigInteger('usuario_creador')->nullable();
            $table->timestamps();
            $table->foreign('usuario_creador')->references('id')->on('users')->nullOnDelete();
        });
        Artisan::call('db:seed', array('--class' => 'ItemPerfilEvaluacionSeeder'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_perfil_evaluaciones');
    }
};
