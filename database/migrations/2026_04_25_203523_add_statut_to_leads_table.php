<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // php artisan make:migration add_statut_to_leads_table
public function up(): void
{
    Schema::table('leads', function (Blueprint $table) {
        $table->enum('statut', [
            'nouveau',
            '1er_appel',
            '2eme_appel',
            'lost',
            'promis',
            'ok'
        ])->default('nouveau')->after('type');
    });
}

public function down(): void
{
    Schema::table('leads', function (Blueprint $table) {
        $table->dropColumn('statut');
    });
}
};
