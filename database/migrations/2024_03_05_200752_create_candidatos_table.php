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
        Schema::create('candidatos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email');
            $table->string('rut')->unique();
            $table->string('telefono');
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->string('ci')->nullable();
            $table->string('licencia_municipal')->nullable();
            $table->string('licencia_interna')->nullable();
            $table->string('cv')->nullable();
            $table->string('foto')->nullable();
            $table->tinyInteger('estado')->default(1);
            $table->timestamps();
            $table->foreign('empresa_id')->references('id')->on('empresas')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidatos');
    }
};
