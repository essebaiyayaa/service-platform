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
        Schema::create('choisir_domicils', function (Blueprint $table) {
            $table->unsignedBigInteger('idBabysitter');
            $table->unsignedBigInteger('idDomicil');

            // Clé primaire composite
            $table->primary(['idDomicil', 'idBabysitter']);

            // Foreign keys
            $table->foreign('idDomicil')
                  ->references('idDomicil')
                  ->on('preference_domicils')
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
        Schema::table('choisir_domicils', function (Blueprint $table) {
            $table->dropForeign(['idDomicil']);
            $table->dropForeign(['idBabysitter']);
        });
        Schema::dropIfExists('choisir_domicils');
    }
};
