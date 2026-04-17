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
        Schema::create('user_taches', function (Blueprint $table) {
            $table->id('idUserTache');
            $table->unsignedBigInteger('idTache')->nullable();
            $table->unsignedBigInteger('idUser')->nullable();
            $table->foreign('idTache')->references('idTache')->on('taches')->cascadeOnDelete();
            $table->foreign('idUser')->references('idUser')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user__taches');
    }
};
