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
        Schema::table('taches', function (Blueprint $table) {
            $table->unsignedBigInteger('idDepartement')->nullable()->after('idObjectif');
            $table->foreign('idDepartement')->references('idDepartement')->on('departements')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('taches', function (Blueprint $table) {
            $table->dropForeign(['idDepartement']);
            $table->dropColumn('idDepartement');
        });
    }
};
