<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('choisir_superpourvoirs', function (Blueprint $table) {
            $table->unsignedBigInteger('idBabysitter');
            $table->unsignedBigInteger('idSuperpouvoir');

            // Clé primaire composite
            $table->primary(['idBabysitter', 'idSuperpouvoir']);

            // Foreign keys
            $table->foreign('idSuperpouvoir')
                  ->references('idSuperpouvoir')
                  ->on('superpouvoirs')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('idBabysitter')
                  ->references('idBabysitter')
                  ->on('babysitters')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('choisir_superpouvoirs', function (Blueprint $table) {
            $table->dropForeign(['idSuperpouvoir']);
            $table->dropForeign(['idBabysitter']);
        });
        Schema::dropIfExists('choisir_superpourvoirs');
    }
};
