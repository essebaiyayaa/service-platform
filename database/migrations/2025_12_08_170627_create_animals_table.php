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
        Schema::create('animals', function (Blueprint $table) {
            $table->id('idAnimale');
            $table->unsignedBigInteger('idDemande');
            $table->string('nomAnimal', 255);
            $table->double('poids');
            $table->double('taille');
            $table->unsignedInteger('age');
            $table->string('sexe', 2);
            $table->string('race', 50);
            $table->string('espece', 50);
            $table->enum('statutVaccination', ['ONCE','RECURRING','NEVER','MULTIPLE']);
            $table->string('note_comportementale');
            $table->timestamps();

            $table->foreign('idDemande')
                  ->references('idDemande')
                  ->on('demandes_intervention')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
