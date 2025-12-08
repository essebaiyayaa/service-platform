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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id('idFeedBack');
            $table->unsignedBigInteger('idAuteur');
            $table->unsignedBigInteger('idCible');
            $table->enum('typeAuteur', ['client', 'intervenant']);
            $table->text('commentaire')->nullable();
            $table->integer('credibilite')->nullable()->check('credibilite >= 0 AND credibilite <= 5');
            $table->integer('sympathie')->nullable()->check('sympathie >= 0 AND sympathie <= 5');
            $table->integer('ponctualite')->nullable()->check('ponctualite >= 0 AND ponctualite <= 5');
            $table->integer('proprete')->nullable()->check('proprete >= 0 AND proprete <= 5');
            $table->integer('qualiteTravail')->nullable()->check('qualiteTravail >= 0 AND qualiteTravail <= 5');
            $table->boolean('estVisible')->default(true);
            $table->dateTime('dateAffichage')->nullable();
            $table->dateTime('dateCreation')->useCurrent();
            $table->unsignedBigInteger('idDemande')->nullable();

            // Foreign keys
            $table->foreign('idDemande')
                  ->references('idDemande')
                  ->on('demandes_intervention')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            $table->foreign('idAuteur')
                  ->references('idUser')
                  ->on('utilisateurs')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('idCible')
                  ->references('idUser')
                  ->on('utilisateurs')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->dropForeign(['idDemande']);
            $table->dropForeign(['idAuteur']);
            $table->dropForeign(['idCible']);
        });
        
        Schema::dropIfExists('feedbacks');
    }
};
