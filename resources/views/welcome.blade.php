<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stage_app - Plateforme de gestion de stage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="text-2xl font-bold text-gray-800">Stage_app</div>
                <div class="flex space-x-4">
                    <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-900">Inscription</a>
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Connexion</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl lg:text-6xl font-bold mb-6">
                        Bienvenue sur notre plateforme de gestion de stage
                    </h1>
                    <p class="text-xl mb-8">
                        StagePro est une plateforme de gestion de stage où étudiants et entreprises se rencontrent pour construire l'avenir professionnel. Un stage, c'est une opportunité, un avenir !
                    </p>
                    <p class="text-lg mb-8">
                        Trouve le stage qui te correspond, développe tes compétences, et bâtis ta carrière dès aujourd'hui.
                    </p>
                    <div class="flex space-x-4">
                        <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                            Commencer maintenant
                        </a>
                        <a href="#about" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-300">
                            En savoir plus
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-white rounded-lg p-6 shadow-2xl">
                        <div class="bg-gray-100 rounded-lg p-4 mb-4">
                            <div class="flex space-x-2 mb-2">
                                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            </div>
                            <div class="bg-white rounded p-3">
                                <div class="grid grid-cols-3 gap-2 mb-3">
                                    <div class="h-8 bg-blue-200 rounded"></div>
                                    <div class="h-8 bg-green-200 rounded"></div>
                                    <div class="h-8 bg-yellow-200 rounded"></div>
                                    <div class="h-8 bg-red-200 rounded"></div>
                                    <div class="h-8 bg-purple-200 rounded"></div>
                                    <div class="h-8 bg-pink-200 rounded"></div>
                                </div>
                                <div class="flex space-x-2">
                                    <div class="w-16 h-16 bg-blue-300 rounded-full"></div>
                                    <div class="w-16 h-16 bg-green-300 rounded-full"></div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                            <span class="text-sm text-gray-600">Dashboard interactif</span>
                        </div>
                    </div>
                    <div class="absolute -bottom-4 -left-4 w-8 h-8 bg-green-400 rounded-full"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-800 rounded-lg p-8 text-white">
                <h2 class="text-3xl font-bold mb-8 text-center">Qui Sommes-nous??</h2>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="relative">
                        <div class="bg-white rounded-lg p-6 shadow-lg">
                            <div class="flex space-x-2 mb-4">
                                <div class="w-8 h-8 bg-blue-500 rounded-full"></div>
                                <div class="w-8 h-8 bg-green-500 rounded-full"></div>
                                <div class="w-8 h-8 bg-yellow-500 rounded-full"></div>
                                <div class="w-8 h-8 bg-red-500 rounded-full"></div>
                                <div class="w-8 h-8 bg-purple-500 rounded-full"></div>
                            </div>
                            <div class="bg-gray-100 rounded-lg p-4">
                                <div class="w-full h-32 bg-gray-200 rounded mb-2"></div>
                                <div class="flex space-x-2">
                                    <div class="w-12 h-12 bg-blue-300 rounded-full"></div>
                                    <div class="w-12 h-12 bg-green-300 rounded-full"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="text-lg mb-6">
                            Notre équipe est passionnée par la technologie et l'éducation. StagePro est née d'un constat simple : les stages sont essentiels, mais souvent mal gérés.
                        </p>
                        <p class="text-lg mb-6">
                            Nous avons créé cette plateforme pour connecter les bons profils aux bonnes opportunités, et faire des stages une vraie passerelle vers le monde professionnel.
                        </p>
                        <div class="flex space-x-4">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-blue-400">500+</div>
                                <div class="text-sm">Étudiants placés</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-green-400">100+</div>
                                <div class="text-sm">Entreprises partenaires</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-yellow-400">95%</div>
                                <div class="text-sm">Taux de satisfaction</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Nos Partenaires</h2>
                <p class="text-xl text-gray-600">Vous trouverez l'entreprise qui vous convient sur stage_app</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8">
                <!-- Company logos -->
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-blue-600">VIEZMANN</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-red-600">Cora</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-green-600">Auchan</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-gray-600">Peugeot</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-blue-600">Autopolis.lu</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-orange-600">Kiloutou</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-red-600">Alfa Romeo</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-blue-600">Fraikin</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-green-600">La Poste</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-gray-600">Porsche</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-blue-600">STEF-TFE</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-red-600">LUKAUTOLU</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-blue-600">France 3</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-black">Adidas</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-green-600">Champion</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-blue-600">DAF</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-gray-600">Lafarge</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-blue-600">EDF</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-orange-600">SNCF</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-green-600">GDF SUEZ</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-blue-600">Norske Skog</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-red-600">Norauto</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-gray-600">Mercedes-Benz</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <div class="text-lg font-bold text-yellow-600">Lamborghini</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Sections -->
    <section class="py-20 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Recruiter Section -->
                <div class="bg-white rounded-lg p-8 shadow-lg text-center">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Recruteur?</h3>
                    <p class="text-lg text-gray-600 mb-6">
                        Recrutez dès maintenant les meilleurs étudiants et les jeunes diplômés
                    </p>
                    <div class="mb-6">
                        <div class="bg-gray-100 rounded-lg p-6 inline-block">
                            <div class="flex space-x-2 mb-4">
                                <div class="w-12 h-12 bg-blue-500 rounded-full"></div>
                                <div class="w-12 h-12 bg-green-500 rounded-full"></div>
                            </div>
                            <div class="w-24 h-1 bg-gray-300 rounded"></div>
                        </div>
                    </div>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                        Commencer le recrutement
                    </a>
                </div>

                <!-- Student Section -->
                <div class="bg-white rounded-lg p-8 shadow-lg text-center">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Étudiant??</h3>
                    <p class="text-lg text-gray-600 mb-6">
                        Trouve le stage qui te correspond, développe tes compétences, et bâtis ta carrière dès aujourd'hui
                    </p>
                    <div class="mb-6">
                        <div class="bg-gray-100 rounded-lg p-6 inline-block">
                            <div class="w-16 h-16 bg-purple-500 rounded-full mx-auto mb-2"></div>
                            <div class="w-24 h-8 bg-gray-200 rounded"></div>
                        </div>
                    </div>
                    <a href="{{ route('register') }}" class="bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition duration-300">
                        Trouver mon stage
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="text-2xl font-bold mb-4">Stage_app</div>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Étudiants</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-gray-300">S'inscrire</a></li>
                        <li><a href="#" class="hover:text-gray-300">Rechercher des stages</a></li>
                        <li><a href="#" class="hover:text-gray-300">Découvrir des entreprises</a></li>
                        <li><a href="#" class="hover:text-gray-300">Événements de recrutements</a></li>
                        <li><a href="#" class="hover:text-gray-300">Offres de stages</a></li>
                        <li><a href="#" class="hover:text-gray-300">Conseils en recrutements</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Entreprises</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-gray-300">Stage_app pour les entreprises</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Stage_app</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-gray-300">Qui Sommes-nous?</a></li>
                        <li><a href="#" class="hover:text-gray-300">Rejoignez-nous</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex space-x-4 text-sm">
                        <a href="#" class="hover:text-gray-300">Mentions légales</a>
                        <span class="text-gray-600">•</span>
                        <a href="#" class="hover:text-gray-300">Politique de confidentialité</a>
                        <span class="text-gray-600">•</span>
                        <a href="#" class="hover:text-gray-300">Contact</a>
                    </div>
                    <div class="text-sm text-gray-400 mt-4 md:mt-0">
                        Copyright© 2025 Stage_app. Tous droits réservés.
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
