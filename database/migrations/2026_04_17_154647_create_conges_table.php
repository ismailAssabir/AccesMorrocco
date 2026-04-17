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
        Schema::create('conges', function (Blueprint $table) {
            $table->id('idConge');
            $table->unsignedBigInteger('idUser');
            $table->foreign('idUser')->references('idUser')->on('users')->cascadeOnDelete();
            $table->integer('sold')->default(0);
            $table->enum('type', ['annuel','maladie','sans_solde'])->default('annuel');
            $table->text('justification')->nullable();
            $table->enum('status', ['en_attente','approuve','refuse'])->default('en_attente');
            $table->string('motif')->nullable();
            $table->date('dateDebut')->nullable();
            $table->date('dateFin')->nullable();
            $table->date('dateDemande')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conges');
    }
};
