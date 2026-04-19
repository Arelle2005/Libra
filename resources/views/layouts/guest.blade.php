<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Libra') }} - @yield('title', 'Authentification')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Styles personnalisés Libra -->
        <style>
            .libra-gradient {
                background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #1e293b 100%);
            }
            .libra-input {
                @apply w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-300;
            }
            .libra-btn {
                @apply w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300;
            }
        </style>
    </head>
    <body class="font-sans antialiased libra-gradient min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="w-full max-w-md space-y-8">
            
            <!-- Contenu de la page (formulaire login/register) -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <div class="text-center text-indigo-200 text-xs">
                <p><i class="fas fa-code text-teal-400"></i> Développé par <span class="font-semibold">AZOUTSA ZONSOP OVIANE ARELLE</span> | IAI Cameroun 2026</p>
            </div>
            
        </div>

    </body>
</html>