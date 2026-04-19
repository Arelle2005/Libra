{{-- resources/views/app/master.blade.php --}}
{{-- Layout principal avec @include et @yield --}}
{{-- Structure : Header + Content + Footer --}}

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- Titre dynamique --}}
    <title>@yield('title', 'Libra - Gestion Bibliothèque Universitaire')</title>
    
    {{-- Tailwind CSS via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Font Awesome pour les icônes --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    {{-- Styles personnalisés --}}
    <style>
        [x-cloak] { display: none !important; }
        .gradient-card { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
    
    {{-- Stack pour les styles supplémentaires (par page) --}}
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans min-h-screen flex flex-col">
    
    {{-- Inclusion du header --}}
    @include('app.header')

    {{-- Messages Flash (Succès / Erreur) --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
         class="container mx-auto px-4 mt-4" x-cloak>
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-lg shadow-md flex justify-between items-center">
            <p>
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </p>
            <button @click="show = false" class="text-emerald-700 hover:text-emerald-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
         class="container mx-auto px-4 mt-4" x-cloak>
        <div class="bg-rose-100 border-l-4 border-rose-500 text-rose-700 p-4 rounded-lg shadow-md flex justify-between items-center">
            <p>
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </p>
            <button @click="show = false" class="text-rose-700 hover:text-rose-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    @if(session('warning'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
         class="container mx-auto px-4 mt-4" x-cloak>
        <div class="bg-amber-100 border-l-4 border-amber-500 text-amber-700 p-4 rounded-lg shadow-md flex justify-between items-center">
            <p>
                <i class="fas fa-exclamation-triangle mr-2"></i>
                {{ session('warning') }}
            </p>
            <button @click="show = false" class="text-amber-700 hover:text-amber-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    {{-- Contenu principal (injecté par @yield) --}}
    <main class="container mx-auto px-4 py-6 flex-grow">
        @yield('content')
    </main>

    {{-- Inclusion du footer --}}
    @include('app.footer')

    {{-- Alpine.js pour les interactions (messages, modals, etc.) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    {{-- Scripts personnalisés (stack) --}}
    @stack('scripts')
    
    {{-- Script pour la confirmation des suppressions --}}
    <script>
        // Confirmation pour les formulaires de suppression
        document.querySelectorAll('form[data-confirm]').forEach(form => {
            form.addEventListener('submit', function(e) {
                const message = this.getAttribute('data-confirm') || 'Êtes-vous sûr ?';
                if (!confirm(message)) {
                    e.preventDefault();
                }
            });
        });

        // Token CSRF pour les requêtes AJAX
        document.addEventListener('DOMContentLoaded', function() {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            if (token) {
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
            }
        });
    </script>
</body>
</html>