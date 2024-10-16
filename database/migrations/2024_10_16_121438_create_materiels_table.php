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
        Schema::create('materiels', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['ordinateur', 'imprimante', 'videoprojecteur']); // Type de matériel
            $table->string('marque');
            $table->string('modele');
            $table->string('numero_serie');//->unique(); // Un numéro de série doit être unique
            $table->boolean('est_disponible')->default(true); // Matériel disponible ou non
            $table->boolean('est_fonctionnel')->default(true);
            $table->date('date_fabrication')->nullable();
            $table->date('date_amortissement')->nullable();
            $table->boolean('est_amorti')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materiels');
    }
};
