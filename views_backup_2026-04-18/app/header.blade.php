{{-- resources/views/app/header.blade.php --}}
<header class="bg-gradient-to-r from-indigo-900 via-purple-900 to-slate-900 shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
            
            {{-- Logo et Titre --}}
            <div class="flex items-center gap-4">
                <div class="bg-white rounded-xl p-2 shadow-md">
                    <img src="{{ asset('images/logoiai.webp') }}" 
                         alt="IAI Cameroun" 
                         class="h-12 w-auto object-contain">
                </div>
                <div class="hidden md:block">
                    <h1 class="text-xl font-bold text-white">
                        <i class="fas fa-book-open mr-2 text-teal-400"></i>Libra
                    </h1>
                    <p class="text-indigo-200 text-xs">Gestion Bibliothèque</p>
                </div>
            </div>

            {{-- Navigation --}}
            @auth
            <nav class="hidden lg:flex items-center gap-2">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 text-white hover:bg-indigo-800 rounded-lg">
                    <i class="fas fa-home mr-1"></i>Accueil
                </a>
                <a href="{{ route('books.index') }}" class="px-4 py-2 text-white hover:bg-indigo-800 rounded-lg">
                    <i class="fas fa-book mr-1"></i>Livres
                </a>
                <a href="{{ route('borrowers.index') }}" class="px-4 py-2 text-white hover:bg-indigo-800 rounded-lg">
                    <i class="fas fa-users mr-1"></i>Emprunteurs
                </a>
                <a href="{{ route('borrows.index') }}" class="px-4 py-2 text-white hover:bg-indigo-800 rounded-lg">
                    <i class="fas fa-exchange-alt mr-1"></i>Emprunts
                </a>
            </nav>

            {{-- Menu Utilisateur --}}
            <div class="flex items-center gap-3">
                <span class="text-indigo-200 text-sm hidden sm:block">
                    <i class="fas fa-user mr-1"></i>{{ Auth::user()->name }}
                </span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-rose-500 hover:bg-rose-600 px-4 py-2 rounded-lg text-sm text-white">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
            @else
            <a href="{{ route('login') }}" class="bg-teal-600 hover:bg-teal-700 px-4 py-2 rounded-lg text-sm text-white">
                <i class="fas fa-sign-in-alt mr-1"></i>Connexion
            </a>
            @endauth
        </div>

        {{-- Navigation Mobile --}}
        @auth
        <div class="lg:hidden mt-3 pt-3 border-t border-indigo-800">
            <nav class="flex flex-wrap gap-2 justify-center">
                <a href="{{ route('dashboard') }}" class="px-3 py-2 text-white hover:bg-indigo-800 rounded-lg text-sm">
                    <i class="fas fa-home"></i>
                </a>
                <a href="{{ route('books.index') }}" class="px-3 py-2 text-white hover:bg-indigo-800 rounded-lg text-sm">
                    <i class="fas fa-book"></i>
                </a>
                <a href="{{ route('borrowers.index') }}" class="px-3 py-2 text-white hover:bg-indigo-800 rounded-lg text-sm">
                    <i class="fas fa-users"></i>
                </a>
                <a href="{{ route('borrows.index') }}" class="px-3 py-2 text-white hover:bg-indigo-800 rounded-lg text-sm">
                    <i class="fas fa-exchange-alt"></i>
                </a>
            </nav>
        </div>
        @endauth
    </div>
</header>