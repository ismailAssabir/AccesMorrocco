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
        Schema::create('souvenirs', function (Blueprint $table) {
            $table->id('idSouvenir');
            $table->unsignedBigInteger('idClient');
            $table->unsignedBigInteger('idDossier')->nullable();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->date('date')->nullable();
            $table->string('mood')->nullable(); // For emojis/feelings
            $table->string('location')->nullable();
            $table->timestamps();

            $table->foreign('idClient')->references('idClient')->on('clients')->onDelete('cascade');
            $table->foreign('idDossier')->references('idDossier')->on('dossiers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('souvenirs');
    }
};
