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
        Schema::create('bitacoras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('candidato_id');
            $table->unsignedBigInteger('empresa_nueva_id');
            $table->unsignedBigInteger('empresa_antigua_id')->nullable();
            $table->timestamps();
            $table->foreign('candidato_id')->references('id')->on('candidatos')->cascadeOnDelete();
            $table->foreign('empresa_nueva_id')->references('id')->on('empresas')->cascadeOnDelete();
            $table->foreign('empresa_antigua_id')->references('id')->on('empresas')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bitacoras');
    }
};
