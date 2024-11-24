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
        Schema::create('criterio_desempeño_internos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('competencia_id');
            $table->string('llave')->unique();
            $table->text('criterio');
            $table->timestamps();
            $table->foreign('competencia_id')->references('id')->on('competencias')->cascadeOnDelete();
        });
        Artisan::call('db:seed', array('--class' => 'CriteriosSeeder'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('criterio_desempeño_internos');
    }
};
