<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS pour couleurs sobres -->
        <style>
            body {
                background-color: #f5f5dc !important; /* beige */
                color: #111 !important;
            }
            .bg-white, .bg-light {
                background-color: #fff !important;
            }
            .bg-dark, .dark\:bg-gray-900, .dark\:bg-gray-800 {
                background-color: #111 !important;
            }
            .btn-primary, .btn-primary:focus, .btn-primary:active {
                background-color: #111 !important;
                border-color: #111 !important;
                color: #f5f5dc !important;
            }
            .btn-primary:hover {
                background-color: #222 !important;
                color: #fff !important;
            }
            .form-control, input, select, textarea {
                background-color: #fff !important;
                color: #111 !important;
                border-radius: 0.5rem;
            }
            label, .text-gray-600, .dark\:text-gray-400 {
                color: #222 !important;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center" style="background-color: #f5f5dc;">
            <!-- Logo supprimé -->
            <div class="w-100" style="max-width: 420px; margin-top: 2rem;">
                <div class="p-4 bg-white shadow rounded-3">
                    {{ $slot }}
                </div>
            </div>
        </div>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
