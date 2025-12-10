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
         Schema::create('demandes_intervention', function (Blueprint $table) {
            $table->id('idDemande');
            $table->timestamp('dateDemande')->useCurrent();
            $table->date('dateSouhaitee');
            $table->time('heureDebut')->nullable();
            $table->time('heureFin')->nullable();
            $table->enum('statut', ['validée', 'en_attente', 'refusée', 'annulée'])->default('en_attente');
            $table->string('raisonAnnulation', 255)->nullable();
            $table->string('lieu', 255)->nullable();
            $table->string('note_speciales', 255)->nullable();
            $table->unsignedBigInteger('idIntervenant')->nullable();
            $table->unsignedBigInteger('idClient');
            $table->unsignedBigInteger('idService')->nullable();

            // Foreign keys
            $table->foreign('idIntervenant')
                  ->references('idIntervenant')
                  ->on('intervenants')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            $table->foreign('idClient')
                  ->references('idUser')
                  ->on('utilisateurs')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('idService')
                  ->references('idService')
                  ->on('services')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demandes_intervention', function (Blueprint $table) {
            $table->dropForeign(['idIntervenant']);
            $table->dropForeign(['idClient']);
            $table->dropForeign(['idService']);
        });
        Schema::dropIfExists('demandes_intervention');
    }
};
