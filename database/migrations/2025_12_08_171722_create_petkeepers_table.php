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
        Schema::create('petkeepers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idPetKeeper');
            $table->unsignedInteger('nombres_services_demandes');
            $table->string('specialite', 255);
            $table->timestamps();

            $table->foreign('idPetKeeper')
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
        Schema::dropIfExists('petkeepers');
    }
};
