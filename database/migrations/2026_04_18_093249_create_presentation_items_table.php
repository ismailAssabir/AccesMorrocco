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
        Schema::create('presentation_items', function (Blueprint $table) {
            $table->id('idItems');
            $table->unsignedBigInteger('idPresentation');
            $table->unsignedBigInteger('idCategory')->nullable();
            $table->foreign('idPresentation')->references('idPresentation')->on('presentations')->cascadeOnDelete();
            $table->foreign('idCategory')->references('idCategory')->on('categories')->nullOnDelete();
            $table->string('nom');
            $table->decimal('prixUnitaire', 10,3);
            $table->integer('quantity')->default(1);
            $table->decimal('totale', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presentation_items');
    }
};
