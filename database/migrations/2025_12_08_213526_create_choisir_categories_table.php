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
        Schema::create('choisir_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('idCategorie');
            $table->unsignedBigInteger('idBabysitter');

            // Clé primaire composite
            $table->primary(['idCategorie', 'idBabysitter']);

            // Foreign keys
            $table->foreign('idCategorie')
                  ->references('idCategorie')
                  ->on('categorie_enfants')
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
        Schema::table('choisir_categories', function (Blueprint $table) {
            $table->dropForeign(['idCategorie']);
            $table->dropForeign(['idBabysitter']);
        });
        Schema::dropIfExists('choisir_categories');
    }
};
