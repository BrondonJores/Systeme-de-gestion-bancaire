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
        Schema::create('virements', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['transfert', 'depot', 'retrait', 'frais', 'interet']);
            $table->enum('statut', ['en cours', 'effectue', 'echoue'])->default('en cours');
            $table->string('reference')->unique();
            $table->string('description')->nullable();
            $table->decimal('montant', 15, 2)->nullable();

            $table->foreignId('id_compte_emetteur')->nullable()->constrained('compte_bancaires');
            $table->foreignId('id_compte_destinataire')->nullable()->constrained('compte_bancaires');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('virements');
    }
};
