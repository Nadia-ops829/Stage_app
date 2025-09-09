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
        Schema::create('rapports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id');
            $table->unsignedBigInteger('stage_id');
            $table->string('fichier');
            $table->text('commentaire_etudiant')->nullable();
            $table->text('commentaire_entreprise')->nullable();
            $table->enum('statut', ['en_attente', 'valide', 'refuse'])->default('en_attente');
            $table->date('date_depot');
            $table->date('date_validation')->nullable();
            $table->timestamps();

            // Clés étrangères
            $table->foreign('etudiant_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('stage_id')->references('id')->on('stages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapports');
    }
};
