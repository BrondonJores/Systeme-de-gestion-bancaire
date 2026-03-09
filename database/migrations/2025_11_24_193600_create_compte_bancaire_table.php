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
        Schema::create('compte_bancaires', function (Blueprint $table) {
            $table->id();
            $table->string('rib')->unique();
            $table->enum('type', ['courant', 'epargne']);
            $table->enum('statut', ['actif', 'inactif', 'ferme'])->default('inactif');
            $table->decimal('solde', 15, 2)->default(0);
            $table->boolean('has_interest')->default(false);
            $table->decimal('taux_interet', 5, 2)->nullable();
            $table->boolean('has_fees')->default(false);
            $table->decimal('frais', 10, 2)->nullable();
            $table->decimal('plafond', 15, 2)->nullable();
            !

            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compte_bancaires');
    }
};
