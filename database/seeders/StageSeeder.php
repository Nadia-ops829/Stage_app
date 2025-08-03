<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stage;
use App\Models\User;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les entreprises existantes
        $entreprises = User::where('role', 'entreprise')->get();

        if ($entreprises->isEmpty()) {
            $this->command->info('Aucune entreprise trouvée. Création d\'une entreprise de test...');
            $entreprise = User::create([
                'nom' => 'TechCorp',
                'prenom' => '',
                'email' => 'techcorp@example.com',
                'password' => bcrypt('password'),
                'role' => 'entreprise',
                'domaine' => 'Technologies',
                'adresse' => '123 Rue de la Tech, 75001 Paris'
            ]);
        } else {
            $entreprise = $entreprises->first();
        }

        $stages = [
            [
                'titre' => 'Développeur Full-Stack',
                'description' => 'Nous recherchons un stagiaire pour développer des applications web modernes. Vous travaillerez sur des projets concrets avec notre équipe de développement.',
                'domaine' => 'Technologies',
                'niveau_requis' => 'Master',
                'duree' => '6 mois',
                'lieu' => 'Paris',
                'remuneration' => 1200.00,
                'date_debut' => '2025-02-01',
                'date_fin' => '2025-07-31',
                'nombre_places' => 2,
                'competences_requises' => ['JavaScript', 'React', 'Node.js', 'MySQL']
            ],
            [
                'titre' => 'Data Scientist',
                'description' => 'Stage en data science pour analyser de grandes quantités de données et développer des modèles prédictifs.',
                'domaine' => 'Technologies',
                'niveau_requis' => 'Master',
                'duree' => '4 mois',
                'lieu' => 'Lyon',
                'remuneration' => 1400.00,
                'date_debut' => '2025-03-01',
                'date_fin' => '2025-06-30',
                'nombre_places' => 1,
                'competences_requises' => ['Python', 'R', 'Machine Learning', 'SQL']
            ],
            [
                'titre' => 'Marketing Digital',
                'description' => 'Stage en marketing digital pour gérer les campagnes publicitaires et optimiser la présence en ligne.',
                'domaine' => 'Marketing',
                'niveau_requis' => 'Licence',
                'duree' => '3 mois',
                'lieu' => 'Toulouse',
                'remuneration' => 800.00,
                'date_debut' => '2025-04-01',
                'date_fin' => '2025-06-30',
                'nombre_places' => 1,
                'competences_requises' => ['Google Ads', 'Facebook Ads', 'Analytics', 'SEO']
            ],
            [
                'titre' => 'Analyste Financier',
                'description' => 'Stage en analyse financière pour participer à l\'analyse des marchés et à la gestion de portefeuilles.',
                'domaine' => 'Finance',
                'niveau_requis' => 'Master',
                'duree' => '6 mois',
                'lieu' => 'Paris',
                'remuneration' => 1500.00,
                'date_debut' => '2025-02-15',
                'date_fin' => '2025-08-15',
                'nombre_places' => 1,
                'competences_requises' => ['Excel', 'VBA', 'Analyse financière', 'Bloomberg']
            ]
        ];

        foreach ($stages as $stageData) {
            Stage::updateOrCreate(
                [
                    'titre' => $stageData['titre'],
                    'entreprise_id' => $entreprise->id
                ],
                array_merge($stageData, [
                    'entreprise_id' => $entreprise->id,
                    'statut' => 'active'
                ])
            );
        }

        $this->command->info('Stages créés avec succès !');
    }
}
