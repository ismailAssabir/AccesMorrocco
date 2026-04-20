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
        Schema::create('dossiers', function (Blueprint $table) {
            $table->id('idDossier');
            $table->unsignedBigInteger('idClient');
            $table->unsignedBigInteger('idDepartement')->nullable();
            $table->foreign('idClient')->references('idClient')->on('clients')->cascadeOnDelete();
            $table->foreign('idDepartement')->references('idDepartement')->on('departements')->cascadeOnDelete();
            $table->string('reference')->unique();
            $table->string('distination')->nullable();
            $table->timestamps('dateCreation')->current();
            $table->date('dateVoyage')->nullable();
            $table->integer('nombrePersonnes')->default(1);
            $table->decimal('montant', 10, 2)->default(0);
            $table->text('commentaire')->nullable();
            $table->text('reponse')->nullable();
            $table->integer('nombreJours')->default(0);
            $table->string('document')->nullable();
            $table->string('titreDocument')->nullable();
            $table->enum('status', ['ouvert','en_cours','ferme'])->default('ouvert');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dossiers');
    }
};
