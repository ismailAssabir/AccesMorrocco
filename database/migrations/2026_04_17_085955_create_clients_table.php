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
        Schema::create('clients', function (Blueprint $table) {
            $table->id('idClient');
            $table->string('firstName',25);
            $table->string('lastName',25);
            $table->string('email',30)->unique();
            $table->string('password',20);
            $table->string('adress',80)->nullable();
            $table->string('CNE',25)->nullable();
            $table->string('phoneNumber',15)->nullable();
            $table->string('nationalite', 40)->nullable();
            $table->date('dateNaissance')->nullable();
            $table->enum('status', ['actif','inactif'])->default('actif');
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
