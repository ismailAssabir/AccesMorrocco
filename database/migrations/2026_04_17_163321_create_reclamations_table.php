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
        Schema::create('reclamations', function (Blueprint $table) {
            $table->id('idReclamation');
            $table->unsignedBigInteger('idUser')->nullable();
            $table->foreign('idUser')->references('idUser')->on('users')->nullOnDelete();
            $table->text('description');
            $table->date('dateEnvoi')->nullable();
            $table->enum('status', ['ouverte','en_cours','resolue'])->default('ouverte');
            $table->enum('priorite', ['basse','moyenne','haute'])->default('moyenne');
            $table->text('reponse')->nullable();
            $table->string('titre');
            $table->string('fichier')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reclamations');
    }
};
