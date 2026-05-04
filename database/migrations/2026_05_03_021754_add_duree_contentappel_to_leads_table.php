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
        Schema::table('leads', function (Blueprint $table) {
            if (!Schema::hasColumn('leads', 'duree')) {
                $table->time('duree')->nullable()->after('note');
            }
            if (!Schema::hasColumn('leads', 'contentAppel')) {
                $table->text('contentAppel')->nullable()->after('duree');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn(['duree', 'contentAppel']);
        });
    }
};
