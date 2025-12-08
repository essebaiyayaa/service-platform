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
        Schema::create('petkeeper_certifications', function (Blueprint $table) {
            $table->id('idCertification');
            $table->unsignedBigInteger('idPetKeeper');
            $table->string('certification', 255);
            $table->string('document', 255);
            $table->timestamps();


            $table->foreign('idPetKeeper')
                  ->references('idPetKeeper')
                  ->on('petkeepers')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petkeeper_certifications');
    }
};
