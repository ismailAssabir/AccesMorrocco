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
        Schema::table('dossiers', function (Blueprint $table) {
        
            $table->unsignedBigInteger('idUser')->nullable()->after('idDossier');
            $table->foreign('idUser')->references('idUser')->on('users')->nullOnDelete();
        });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('dossiers', function (Blueprint $table) {
            $table->dropForeign(['idUser']);
            $table->dropColumn('idUser');
        });
    }
};
