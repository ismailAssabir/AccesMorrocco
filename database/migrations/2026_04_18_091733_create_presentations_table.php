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
        Schema::create('presentations', function (Blueprint $table) {
            $table->id('idPresentation');
            $table->unsignedBigInteger('idDossier');
            $table->foreign('idDossier')->references('idDossier')->on('dossiers')->cascadeOnDelete();
            $table->string('titre');
            $table->date('date')->nullable();
            $table->enum('status', ['en_attente','validee','refusee'])->default('en_attente');
            $table->text('comment')->nullable();
            $table->text('reponse')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presentations');
    }
};
