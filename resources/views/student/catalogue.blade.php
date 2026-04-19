{{-- resources/views/student/catalogue.blade.php --}}
{{-- Catalogue des livres pour les étudiants --}}

@extends('app.master')

@section('title', 'Catalogue - Libra')

@section('content')
<!-- En-tête avec Logo IAI -->
<div class="mb-8 bg-gradient-to-r from-indigo-900 via-purple-900 to-slate-900 rounded-2xl shadow-xl p-8 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
    
    <div class="relative z-10 flex items-center justify-between">
        <div class="flex items-center gap-6">
            <div class="bg-white rounded-xl p-3 shadow-lg">
                <img src="{{ asset('images/logoIAI.webp') }}" 
                     alt="IAI Cameroun" 
                     class="h-16 w-auto object-contain">
            </div>
            <div>
                <h1 class="text-4xl font-bold text-white mb-2 tracking-tight">
                    <i class="fas fa-book-reader mr-3 text-teal-400"></i>Catalogue des Livres
                </h1>
                <p class="text-indigo-200 text-lg">Institut Africain d'Informatique - Centre d'Excellence Technologique Paul Biya</p>
                <p class="text-indigo-300 text-sm mt-1">
                    <i class="fas fa-user-graduate mr-2"></i>Bienvenue, {{ $borrower->name }} ({{ $borrower->matricule }})
                </p>
            </div>
        </div>
        <div class="hidden lg:block">
            <form method="POST" action="{{ route('student.logout') }}" class="inline">
                @csrf
                <button type="submit" class="group inline-flex items-center gap-2 bg-rose-500 hover:bg-rose-600 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300">
                    <i class="fas fa-sign-out-alt text-xl group-hover:-rotate-12 transition-transform"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Barre de recherche -->
<div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
    <form method="get" action="{{ route('student.catalogue') }}" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1 relative">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="q" value="{{ request('q') }}" 
                   placeholder="Rechercher par titre, auteur ou ISBN..." 
                   class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
        </div>
        <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold px-8 py-3 rounded-xl shadow-md">
            <i class="fas fa-search mr-2"></i>Rechercher
        </button>
        @if(request('q'))
        <a href="{{ route('student.catalogue') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-8 py-3 rounded-xl text-center">
            <i class="fas fa-times mr-2"></i>Effacer
        </a>
        @endif
    </form>
</div>

<!-- Statistiques rapides -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-indigo-100 text-sm">Total Livres</p>
                <p class="text-3xl font-bold">{{ $books->total() }}</p>
            </div>
            <div class="bg-white/20 p-4 rounded-xl">
                <i class="fas fa-book text-3xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-emerald-100 text-sm">Disponibles</p>
                <p class="text-3xl font-bold">{{ $books->where('available_copies', '>', 0)->count() }}</p>
            </div>
            <div class="bg-white/20 p-4 rounded-xl">
                <i class="fas fa-check-circle text-3xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-amber-100 text-sm">Indisponibles</p>
                <p class="text-3xl font-bold">{{ $books->where('available_copies', '=', 0)->count() }}</p>
            </div>
            <div class="bg-white/20 p-4 rounded-xl">
                <i class="fas fa-times-circle text-3xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Liste des livres -->
<div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
    <div class="bg-gradient-to-r from-slate-800 to-slate-900 px-6 py-4">
        <h2 class="text-xl font-bold text-white"><i class="fas fa-list text-teal-400 mr-2"></i>Liste des Ouvrages</h2>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
        @forelse($books as $book)
        <div class="border-2 border-gray-200 rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 hover:border-indigo-300 group">
            <!-- En-tête de la carte -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-4 py-3">
                <div class="flex items-center justify-between">
                    <span class="text-white font-bold text-sm">
                        <i class="fas fa-book mr-2"></i>Référence
                    </span>
                    @if($book->available_copies > 0)
                    <span class="bg-emerald-400 text-white px-3 py-1 rounded-full text-xs font-bold">
                        <i class="fas fa-check mr-1"></i>Disponible
                    </span>
                    @else
                    <span class="bg-rose-400 text-white px-3 py-1 rounded-full text-xs font-bold">
                        <i class="fas fa-times mr-1"></i>Indisponible
                    </span>
                    @endif
                </div>
            </div>

            <!-- Corps de la carte -->
            <div class="p-4 space-y-3">
                <!-- Titre -->
                <h3 class="text-lg font-bold text-gray-800 group-hover:text-indigo-600 transition-colors line-clamp-2">
                    {{ $book->title }}
                </h3>

                <!-- Auteur -->
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <i class="fas fa-user text-indigo-500"></i>
                    <span class="font-medium">{{ $book->author }}</span>
                </div>

                <!-- ISBN -->
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <i class="fas fa-barcode text-purple-500"></i>
                    <span class="font-mono">{{ $book->isbn }}</span>
                </div>

                <!-- Année -->
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <i class="fas fa-calendar text-teal-500"></i>
                    <span>{{ $book->published_date?->format('Y') ?? 'N/A' }}</span>
                </div>

                <!-- Stock -->
                <div class="flex items-center justify-between pt-3 border-t">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-copy text-orange-500"></i>
                        <span class="text-sm font-bold {{ $book->available_copies > 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $book->available_copies }} / {{ $book->total_copies }}
                        </span>
                    </div>
                    <span class="text-xs text-gray-500">exemplaires</span>
                </div>
            </div>

            <!-- Pied de la carte -->
            <div class="px-4 py-3 bg-gray-50 border-t">
                @if($book->available_copies > 0)
                <button class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-2 px-4 rounded-xl text-sm transition-all duration-300">
                    <i class="fas fa-hand-holding mr-2"></i>Demander ce livre
                </button>
                @else
                <button disabled class="w-full bg-gray-300 text-gray-500 font-semibold py-2 px-4 rounded-xl text-sm cursor-not-allowed">
                    <i class="fas fa-ban mr-2"></i>Actuellement indisponible
                </button>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">Aucun livre trouvé</p>
            @if(request('q'))
            <p class="text-gray-400 text-sm mt-2">Essayez avec d'autres termes de recherche</p>
            @endif
        </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    @if(method_exists($books, 'links'))
    <div class="bg-gray-50 px-6 py-4 border-t">{{ $books->links('pagination::tailwind') }}</div>
    @endif
</div>

<!-- Footer -->
<div class="mt-8 text-center text-gray-500 text-sm">
    <p><i class="fas fa-code text-indigo-600"></i> Développé par <span class="font-semibold">AZOUTSA ZONSOP OVIANE ARELLE</span> | IAI Cameroun 2026</p>
</div>
@endsection