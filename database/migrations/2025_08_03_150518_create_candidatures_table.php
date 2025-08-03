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
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('stage_id')->constrained('stages')->onDelete('cascade');
            $table->enum('statut', ['en_attente', 'acceptee', 'refusee'])->default('en_attente');
            $table->text('lettre_motivation')->nullable();
            $table->string('cv_path')->nullable();
            $table->timestamp('date_candidature')->useCurrent();
            $table->timestamp('date_reponse')->nullable();
            $table->text('commentaire_entreprise')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};
