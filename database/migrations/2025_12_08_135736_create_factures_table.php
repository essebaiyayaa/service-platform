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
        Schema::create('factures', function (Blueprint $table) {
            $table->id('idFacture');
            $table->double('montantTotal');
            $table->integer('numFacture')->unique();
            $table->unsignedBigInteger('idDemande');

            // Foreign key
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
        Schema::table('factures', function (Blueprint $table) {
            $table->dropForeign(['idDemande']);
        });
        Schema::dropIfExists('factures');
    }
};
