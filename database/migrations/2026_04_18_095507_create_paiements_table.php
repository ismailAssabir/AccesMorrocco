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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id('idPaiement');
            $table->unsignedBigInteger('idDossier');
            $table->foreign('idDossier')->references('idDossier')->on('dossiers')->cascadeOnDelete();
            $table->decimal('montantPaye', 10, 2)->default(0);
            $table->decimal('montantReste', 10, 2)->default(0);
            $table->string('modePaiement')->nullable();
            $table->date('date')->nullable();
            $table->string('ref')->nullable();
            $table->enum('status', ['partiel','complet','annule'])->default('partiel');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
