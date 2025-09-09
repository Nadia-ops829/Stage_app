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
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entreprise_id')->constrained('entreprises')->onDelete('cascade');
            $table->string('titre');
            $table->text('description');
            $table->string('domaine');
            $table->string('niveau_requis');
            $table->string('duree');
            $table->string('lieu');
            $table->decimal('remuneration', 8, 2)->nullable();
            $table->enum('statut', ['active', 'inactive', 'terminee'])->default('active');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('nombre_places');
            $table->json('competences_requises')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stages');
    }
}; 