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
        Schema::create('objectifs', function (Blueprint $table) {
            $table->id('idObjectif');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->date('dateFin')->nullable();
            $table->enum('status', ['en_cours','atteint','echoue'])->default('en_cours');
            $table->integer('avancement')->default(0);
            $table->date('dateDebut')->nullable();
            $table->unsignedBigInteger('idDepartement')->nullable();
            $table->foreign('idDepartement')->references('idDepartement')->on('departements')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objectifs');
    }
};
