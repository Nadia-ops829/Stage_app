<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Désactiver temporairement les vérifications de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // 2. Supprimer les colonnes redondantes
        Schema::table('entreprises', function (Blueprint $table) {
            $columnsToDrop = ['email', 'mot_de_passe', 'adresse', 'domaine', 'telephone'];
            
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('entreprises', $column)) {
                    $table->dropColumn($column);
                }
            }
            
            // Ajouter user_id s'il n'existe pas
            if (!Schema::hasColumn('entreprises', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id');
            }
            
            // Ajouter les nouveaux champs
            $newColumns = [
                'description' => 'text',
                'logo' => 'string',
                'site_web' => 'string'
            ];
            
            foreach ($newColumns as $column => $type) {
                if (!Schema::hasColumn('entreprises', $column)) {
                    $table->$type($column)->nullable();
                }
            }
        });
        
        // 3. Ajouter la contrainte de clé étrangère
        try {
            Schema::table('entreprises', function (Blueprint $table) {
                $table->foreign('user_id')
                      ->references('id')
                      ->on('users')
                      ->onDelete('cascade');
            });
        } catch (\Exception $e) {
            // La contrainte existe peut-être déjà
            \Log::info('Erreur lors de l\'ajout de la clé étrangère : ' . $e->getMessage());
        }
        
        // 4. Réactiver les vérifications de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cette migration ne doit pas être rollback car elle supprime des colonnes
        // qui ne peuvent pas être restaurées automatiquement
    }
};
