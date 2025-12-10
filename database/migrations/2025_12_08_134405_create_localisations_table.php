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
         Schema::create('localisations', function (Blueprint $table) {
            $table->id('idLocalisation'); 
            $table->decimal('latitude', 10, 8); 
            $table->decimal('longitude', 11, 8);
            $table->string('ville', 255);
            $table->string('adresse', 255);   

            $table->unsignedBigInteger('idUser');
            $table->foreign('idUser')
                  ->references('idUser')
                  ->on('utilisateurs')
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
        Schema::table('localisations', function (Blueprint $table) {
            $table->dropForeign(['idUser']);
        });
        Schema::dropIfExists('localisations');
    }
};
