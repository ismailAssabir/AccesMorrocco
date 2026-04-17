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
        Schema::create('leads', function (Blueprint $table) {
            $table->id('idLead');
            $table->unsignedBigInteger('idClient')->nullable();
            $table->foreign('idClient')->references('idClient')->on('clients')->nullOnDelete();
            $table->unsignedBigInteger('idDepartement')->nullable();
            $table->foreign('idDepartement')->references('idDepartement')->on('departements')->nullOnDelete();
            $table->unsignedBigInteger('idUser')->nullable();
            $table->foreign('idUser')->references('idUser')->on('users')->nullOnDelete();
            $table->string('firstName',25);
            $table->string('lastName',25);
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('phoneNumber')->nullable();
            $table->string('type',20);
            $table->string('adresse')->nullable();
            $table->string('CNE')->nullable();
            $table->string('source')->nullable();
            $table->text('note')->nullable();
            $table->string('nationalite')->nullable();
            $table->date('dateCreation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
