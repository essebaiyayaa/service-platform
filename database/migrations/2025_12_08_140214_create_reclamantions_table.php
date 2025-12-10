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
        Schema::create('reclamantions', function (Blueprint $table) {
             $table->id('idReclamation'); 

            $table->unsignedBigInteger('idCible');   
            $table->unsignedBigInteger('idAuteur');  
            $table->unsignedBigInteger('idFeedback')->nullable(); 

            $table->enum('statut', ['en_attente', 'resolue'])
                  ->default('en_attente');

            $table->string('preuves', 255)->nullable();
            $table->string('sujet', 255);
            $table->timestamp('dateCreation')->useCurrent();
            $table->text('description')->nullable();

            $table->enum('priorite', ['faible', 'moyenne', 'urgente'])
                  ->default('moyenne');

            // Contraintes étrangères
            $table->foreign('idFeedback')
                  ->references('idFeedBack')
                  ->on('feedbacks')
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
        Schema::table('reclamations', function (Blueprint $table) {
            $table->dropForeign(['idFeedback']);
            $table->dropForeign(['idAuteur']);
            $table->dropForeign(['idCible']);
        });
        Schema::dropIfExists('reclamantions');
    }
};
