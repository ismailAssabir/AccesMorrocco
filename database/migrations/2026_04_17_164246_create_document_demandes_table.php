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
        Schema::create('document_demandes', function (Blueprint $table) {
            $table->id('idDocument');
            $table->unsignedBigInteger('idUser');
            $table->foreign('idUser')->references('idUser')->on('users')->cascadeOnDelete();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->timestamps('dateDemande')->current();
            $table->enum('status', ['en_attente','approuve','refuse'])->default('en_attente');
            $table->enum('type', ['attestation','contrat','autre'])->nullable();
            $table->string('fichiers')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_demandes');
    }
};
