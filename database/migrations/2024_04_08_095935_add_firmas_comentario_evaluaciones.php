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
        Schema::table('evaluaciones', function (Blueprint $table) {
            $table->text('comentarios')->nullable();
            $table->string('firma_evaluador')->nullable();
            $table->string('firma_supervisor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaluaciones', function ($table) {
            $table->dropColumn('comentarios');
            $table->dropColumn('firma_evaluador');
            $table->dropColumn('firma_supervisor');
        });
    }
};
