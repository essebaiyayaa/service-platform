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
        Schema::create('offres_services', function (Blueprint $table) {
            $table->unsignedBigInteger('idIntervenant');
            $table->unsignedBigInteger('idService');

            // Clé primaire composite
            $table->primary(['idIntervenant', 'idService']);

            // Foreign keys
            $table->foreign('idService')
                  ->references('idService')
                  ->on('services')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

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
        Schema::dropIfExists('offres_services');
    }
};
