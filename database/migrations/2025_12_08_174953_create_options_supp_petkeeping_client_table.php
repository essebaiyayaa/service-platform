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
        Schema::create('options_supp_petkeeping_client', function (Blueprint $table) {
            $table->id('idOptionSuppClient');
            $table->unsignedBigInteger('idDemande');
            $table->unsignedBigInteger('idPetKeeper');
            $table->string('nomOption');
            $table->string('description');
            $table->enum('categorieOption', ['GROOMING','WALKING','TRAINING','MEDICATION','PLAYTIME','PHOTO_UPDATES','PICKUP_DROPOFF']);
            $table->double('prix_supp');
            $table->timestamps();

            $table->foreign('idPetKeeper')
                  ->references('idPetKeeper')
                  ->on('petkeepers')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

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
        Schema::dropIfExists('options_supp_petkeeping_client');
    }
};
