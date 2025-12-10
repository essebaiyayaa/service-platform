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
        Schema::create('choisir_experiences', function (Blueprint $table) {
            $table->unsignedBigInteger('idExperience');
            $table->unsignedBigInteger('idBabysitter');

            // Clé primaire composite
            $table->primary(['idExperience', 'idBabysitter']);

            // Foreign keys
            $table->foreign('idExperience')
                  ->references('idExperience')
                  ->on('experience_besoins_speciaux')
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
        Schema::table('choisir_experiences', function (Blueprint $table) {
            $table->dropForeign(['idExperience']);
            $table->dropForeign(['idBabysitter']);
        });
        Schema::dropIfExists('choisir_experiences');
    }
};
