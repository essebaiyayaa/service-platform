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
        Schema::create('payment_criteria', function (Blueprint $table) {
            $table->id('idPaymentCriteria');
            $table->unsignedBigInteger('idPetKeeper');
            $table->enum('criteria', ['PER_HOUR','PER_DAY','PER_NIGHT','PER_VISIT','PER_WALK','PER_PET','PER_SPECIES','PER_WEIGHT','PER_SERVICE','PER_DISTANCE']);
            $table->string('description');
            $table->double('base_price');
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
        Schema::dropIfExists('payment_criteria');
    }
};
