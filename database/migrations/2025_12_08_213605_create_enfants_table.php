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
        Schema::create('enfants', function (Blueprint $table) {
            $table->id('idEnfant');
            $table->string('nomComplet', 255);
            $table->date('dateNaissance');
            $table->text('besoinsSpecifiques')->nullable();
            $table->unsignedBigInteger('idDemande');

            // Foreign key
            $table->foreign('idDemande')
                  ->references('idDemande')
                  ->on('demandes_intervention')
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
        Schema::table('enfants', function (Blueprint $table) {
            $table->dropForeign(['idDemande']);
        });
        Schema::dropIfExists('enfants');
    }
};
