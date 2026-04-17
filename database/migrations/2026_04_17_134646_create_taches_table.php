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
        Schema::create('taches', function (Blueprint $table) {
            $table->id('idTache');
            $table->unsignedBigInteger('idObjectif')->nullable();
            $table->foreign('idObjectif')->references('idObjectif')->on('objectifs')->nullOnDelete();
            $table->string('titre',30);
            $table->date('dateDebut')->nullable();
            $table->date('duree')->nullable();
            $table->enum('typeDuree', ['h', 'jours', 'mois']);
            $table->time('heureDebut')->nullable();
            $table->enum('priorite', ['basse','moyenne','haute'])->default('moyenne');
            $table->enum('status', ['todo','en_cours','termine'])->default('todo');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taches');
    }
};
