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
    Schema::create('users', function (Blueprint $table) {
        $table->id('idUser'); 
        $table->string('firstName', 50);
        $table->string('lastName', 50);
        $table->string('email', 50)->unique(); 
        $table->string('password', 255);
        $table->string('cin', 50)->unique();
        $table->date('birthday');
        $table->string('address', 100)->nullable();
        $table->string('phoneNumber', 15);
        $table->enum('typeContrat', ['CD', 'CI', 'freelance'])->nullable();
        $table->decimal('salaire', 10, 2);
        $table->string('post', 40)->nullable();
        $table->date('dateEmb')->nullable();
        
        $table->unsignedBigInteger('idDepartement')->nullable();
        $table->foreign('idDepartement')
              ->references('idDepartement') 
              ->on('departements')
              ->nullOnDelete();

        $table->enum('status', ['active', 'desactive', 'conge'])->default('active');
        $table->enum('type', ['employee', 'admin', 'manager'])->default('employee');
        $table->string('fichier');
        $table->string('rip');
        $table->timestamp('email_verified_at')->nullable();
        $table->rememberToken();
        $table->timestamps();
    });

    Schema::create('password_reset_tokens', function (Blueprint $table) {
        $table->string('email')->primary();
        $table->string('token');
        $table->timestamp('created_at')->nullable();
    });

    Schema::create('sessions', function (Blueprint $table) {
        $table->string('id')->primary();
        $table->unsignedBigInteger('user_id')->nullable()->index();
        $table->foreign('user_id')->references('idUser')->on('users')->cascadeOnDelete();
        
        $table->string('ip_address', 45)->nullable();
        $table->text('user_agent')->nullable();
        $table->longText('payload');
        $table->integer('last_activity')->index();
    });
}
};
