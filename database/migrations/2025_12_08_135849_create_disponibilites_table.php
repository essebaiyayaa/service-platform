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
         Schema::create('disponibilites', function (Blueprint $table) {
            $table->increments('idDispo'); 
            $table->time('heureDebut');    
            $table->time('heureFin');      
            $table->enum('jourSemaine', [ 
                'Lundi', 'Mardi', 'Mercredi', 'Jeudi',
                'Vendredi', 'Samedi', 'Dimanche',
            ]);

            $table->boolean('est_reccurent')->default(1);
            $table->date('date_specifique')->nullable(); 
            
	
            $table->unsignedBigInteger('idIntervenant');
            $table->foreign('idIntervenant')
                  ->references('idIntervenant')
                  ->on('intervenants')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disponibilites', function (Blueprint $table) {
            $table->dropForeign(['idIntervenant']);
        });
        Schema::dropIfExists('disponibilites');
    }
};
