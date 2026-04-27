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
        Schema::create('primes', function (Blueprint $table) {
            $table->id('idPrime');
            $table->unsignedBigInteger('idUser')->nullable();
            $table->foreign('idUser')->references('idUser')->on('users')->cascadeOnDelete();
            $table->unsignedBigInteger('idTache')->nullable();
            $table->unsignedBigInteger('idPointage')->nullable();
            $table->unsignedBigInteger('idObjectif')->nullable();
            $table->foreign('idTache')->references('idTache')->on('taches')->nullOnDelete();
            $table->foreign('idPointage')->references('idPointage')->on('pointages')->nullOnDelete();
            $table->foreign('idObjectif')->references('idObjectif')->on('objectifs')->nullOnDelete();
            $table->decimal('montant', 10, 2)->default(0);
            $table->string('motif')->nullable();
            $table->date('dateAttribution')->nullable();
            $table->enum('status', ['en_attente','validee','payee'])->default('en_attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('primes');
    }
};
