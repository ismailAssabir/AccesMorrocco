<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL: modifier l'enum pour ajouter les nouveaux statuts NR
        DB::statement("ALTER TABLE `leads` MODIFY `statut` ENUM(
            'nouveau',
            '1er_appel',
            '1er_appel_nr',
            '2eme_appel',
            '2eme_appel_nr',
            'lost',
            'promis',
            'ok'
        ) NOT NULL DEFAULT 'nouveau'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `leads` MODIFY `statut` ENUM(
            'nouveau',
            '1er_appel',
            '2eme_appel',
            'lost',
            'promis',
            'ok'
        ) NOT NULL DEFAULT 'nouveau'");
    }
};
