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
        Schema::create('carte_bancaires', function (Blueprint $table) {
            $table->id();
            $table->string('numero_carte')->unique();
            $table->string('type_carte');
            $table->string('proprietaire');
            $table->date('date_expiration');
            $table->string('cvv');
            $table->boolean('is_actif')->default(true);

            $table->foreignId('id_compte')->constrained('compte_bancaires');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carte_bancaires');
    }
};
