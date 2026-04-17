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
        Schema::create('reunions', function (Blueprint $table) {
            $table->id('idReunion');
            $table->unsignedBigInteger('idDepartement')->nullable();
            $table->foreign('idDepartement')->references('idDepartement')->on('departements')->nullOnDelete();
            $table->string('objectif');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->dateTime('dateHeure')->nullable();
            $table->time('heureFin')->nullable();
            $table->string('type');
            $table->string('lien')->nullable();
            $table->string('lieu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reunions');
    }
};
