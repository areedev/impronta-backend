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
        Schema::table('resultado_evaluaciones', function (Blueprint $table) {
            $table->text('comentario')->nullable();
            $table->string('archivo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resultado_evaluaciones', function ($table) {
            $table->dropColumn('comentario');
            $table->dropColumn('archivo');
        });
    }
};
