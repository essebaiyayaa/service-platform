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
        Schema::create('intervenants', function (Blueprint $table) {
            $table->id();
            $table->enum('statut', ['VALIDE', 'REFUSE', 'EN_ATTENTE'])->default('EN_ATTENTE');
            $table->unsignedBigInteger('IdIntervenant');
            $table->foreign('idIntervenant')
                ->references('idUser')
                ->on('utilisateurs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('idAdmin')->nullable();
            $table->foreign('idAdmin')
                  ->references('idAdmin')
                  ->on('admins')
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
        Schema::table('intervenants', function (Blueprint $table) {
            $table->dropForeign(['idIntervenant']);
            $table->dropForeign(['idAdmin']);
        });
        Schema::dropIfExists('intervenants');
    }
};
