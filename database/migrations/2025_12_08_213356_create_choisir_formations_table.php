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
        Schema::create('choisir_formations', function (Blueprint $table) {
            $table->unsignedBigInteger('idFormation');
            $table->unsignedBigInteger('idBabysitter');

            // Clé primaire composite
            $table->primary(['idFormation', 'idBabysitter']);

            // Foreign keys
            $table->foreign('idFormation')
                  ->references('idFormation')
                  ->on('formations')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('idBabysitter')
                  ->references('idBabysitter')
                  ->on('babysitters')
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
        Schema::table('choisir_formations', function (Blueprint $table) {
            $table->dropForeign(['idFormation']);
            $table->dropForeign(['idBabysitter']);
        });
        Schema::dropIfExists('choisir_formations');
    }
};
