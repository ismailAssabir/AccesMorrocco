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
        Schema::create('pointages', function (Blueprint $table) {
            $table->id('idPointage');
            $table->unsignedBigInteger('idUser');
            $table->foreign('idUser')->references('idUser')->on('users')->cascadeOnDelete();
            $table->time('heureEntree')->nullable();
            $table->time('heureSortie')->nullable();
            $table->date('date')->nullable();
            $table->enum('status', ['present','absent','retard'])->default('present');
            $table->decimal('gps', 10, 7)->nullable();
            $table->string('justification')->nullable();
            $table->string('fichier')->nullable();
            $table->string('typejustif')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pointages');
    }
};
