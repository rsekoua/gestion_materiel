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
        Schema::create('attributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materiel_id')->constrained('materiels')->onDelete('cascade'); // Clé étrangère vers la table des matériels
            $table->foreignId('employe_id')->nullable()->constrained('employes')->onDelete('set null'); // Clé étrangère vers la table des employés
            $table->string('service')->nullable(); // Peut être nul si attribué à un employé
            $table->date('date_attribution');
            $table->date('date_restitution')->nullable(); // Date de restitution, optionnelle

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributions');
    }
};
