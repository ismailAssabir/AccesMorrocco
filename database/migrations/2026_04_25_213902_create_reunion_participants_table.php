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
        Schema::create('reunion_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idReunion');
            $table->unsignedBigInteger('idUser');
            $table->timestamps();

            $table->foreign('idReunion')->references('idReunion')->on('reunions')->onDelete('cascade');
            $table->foreign('idUser')->references('idUser')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reunion_participants');
    }
};
