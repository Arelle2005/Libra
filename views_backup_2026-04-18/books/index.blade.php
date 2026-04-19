{{-- resources/views/books/index.blade.php --}}
{{-- Liste des livres avec recherche et filtrage --}}

@extends('app.master')

@section('title', 'Catalogue des Livres - Libra')

@section('content')
<!-- En-tête avec Logo IAI -->
<div class="mb-8 bg-gradient-to-r from-indigo-900 via-purple-900 to-slate-900 rounded-2xl shadow-xl p-8 relative overflow-hidden">
    <!-- Effet de fond décoratif -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
    
    <div class="relative z-10 flex items-center justify-between">
        <div class="flex items-center gap-6">
            <!-- Logo IAI Cameroun -->
            <div class="bg-white rounded-xl p-3 shadow-lg">
                <img src="{{ asset('images/logoiai.webp') }}"
                     alt="IAI Cameroun" 
                     class="h-16 w-auto object-contain">
            </div>
            <div>
                <h1 class="text-4xl font-bold text-white mb-2 tracking-tight">
                    <i class="fas fa-book-open mr-3 text-teal-400"></i>Catalogue des Livres
                </h1>
                <p class="text-indigo-200 text-lg">Institut Africain d'Informatique - Centre d'Excellence Technologique Paul Biya</p>
                <p class="text-indigo-300 text-sm mt-1">
                    <i class="fas fa-layer-group mr-2"></i>{{ $books->total() ?? 0 }} ouvrage(s) référencé(s)
                </p>
            </div>
        </div>
        <div class="hidden lg:block">
            <a href="{{ route('books.create') }}" class="group inline-flex items-center gap-2 bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-plus-circle text-xl group-hover:rotate-90 transition-transform"></i>
                <span>Ajouter un livre</span>
            </a>
        </div>
    </div>
</div>

<!-- Barre de recherche améliorée -->
<div class="bg-gradient-to-r from-white to-gray-50 rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
    <form method="get" action="{{ route('books.index') }}" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1 relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400 text-lg"></i>
            </div>
            <input type="text" name="q" value="{{ request('q') }}" 
                   placeholder="Rechercher par titre, auteur ou ISBN..." 
                   class="w-full pl-12 pr-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all text-gray-700 font-medium">
        </div>
        <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold px-8 py-3 rounded-xl shadow-md transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
            <i class="fas fa-search"></i>
            <span>Rechercher</span>
        </button>
        @if(request('q'))
        <a href="{{ route('books.index') }}" class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold px-8 py-3 rounded-xl shadow-md transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
            <i class="fas fa-times"></i>
            <span>Effacer</span>
        </a>
        @endif
    </form>
    
    <!-- Filtres rapides -->
    <div class="mt-4 flex flex-wrap gap-2">
        <span class="text-sm text-gray-500 font-medium">Filtres rapides :</span>
        <a href="{{ route('books.index') }}" class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm font-semibold hover:bg-indigo-200 transition-colors">
            <i class="fas fa-list mr-1"></i>Tous
        </a>
        <a href="{{ route('books.index', ['available' => 1]) }}" class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold hover:bg-emerald-200 transition-colors">
            <i class="fas fa-check-circle mr-1"></i>Disponibles
        </a>
    </div>
</div>

<!-- Liste des livres avec design moderne -->
<div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
    <!-- En-tête du tableau -->
    <div class="bg-gradient-to-r from-slate-800 to-slate-900 px-6 py-4">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <i class="fas fa-table text-teal-400"></i>
                Liste des Ouvrages
            </h2>
            <div class="flex items-center gap-2 text-indigo-200 text-sm">
                <i class="fas fa-info-circle"></i>
                <span>Cliquez sur les icônes pour modifier ou supprimer</span>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-indigo-100">
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                        <i class="fas fa-font mr-2 text-indigo-500"></i>Titre
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                        <i class="fas fa-pen-fancy mr-2 text-purple-500"></i>Auteur
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                        <i class="fas fa-barcode mr-2 text-teal-500"></i>ISBN
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                        <i class="fas fa-boxes mr-2 text-orange-500"></i>Disponibilité
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                        <i class="fas fa-cog mr-2 text-gray-500"></i>Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($books as $book)
                <tr class="group hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition-all duration-300">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-3 rounded-xl shadow-md group-hover:scale-110 transition-transform">
                                <i class="fas fa-book text-white text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800 group-hover:text-indigo-700 transition-colors">{{ $book->title }}</p>
                                @if($book->published_date)
                                <p class="text-xs text-gray-500 mt-1">
                                    <i class="far fa-calendar mr-1"></i>{{ $book->published_date->format('Y') }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="bg-purple-100 p-2 rounded-lg">
                                <i class="fas fa-user-edit text-purple-600 text-sm"></i>
                            </div>
                            <span class="text-sm text-gray-700 font-medium">{{ $book->author }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="bg-teal-100 p-2 rounded-lg">
                                <i class="fas fa-barcode text-teal-600 text-sm"></i>
                            </div>
                            <span class="text-sm font-mono text-gray-700 bg-gray-100 px-2 py-1 rounded">{{ $book->isbn }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            @if($book->available_copies > 0)
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-4 py-2 rounded-full text-xs font-bold shadow-md">
                                <i class="fas fa-check-circle mr-1"></i>
                                {{ $book->available_copies }} / {{ $book->total_copies }}
                            </div>
                            <span class="text-xs text-emerald-600 font-semibold">Disponible</span>
                            @else
                            <div class="bg-gradient-to-r from-rose-500 to-pink-600 text-white px-4 py-2 rounded-full text-xs font-bold shadow-md">
                                <i class="fas fa-times-circle mr-1"></i>
                                0 / {{ $book->total_copies }}
                            </div>
                            <span class="text-xs text-rose-600 font-semibold">Épuisé</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('books.edit', $book->id) }}" 
                               class="group/action inline-flex items-center justify-center w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white rounded-xl shadow-md transform hover:scale-110 transition-all duration-300"
                               title="Modifier">
                                <i class="fas fa-edit group-hover/action:rotate-12 transition-transform"></i>
                            </a>
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline" 
                                  data-confirm="Êtes-vous sûr de vouloir supprimer ce livre ?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="group/action inline-flex items-center justify-center w-10 h-10 bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 text-white rounded-xl shadow-md transform hover:scale-110 transition-all duration-300"
                                        title="Supprimer">
                                    <i class="fas fa-trash group-hover/action:rotate-12 transition-transform"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <div class="max-w-md mx-auto">
                            <div class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-book text-5xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-700 mb-2">Aucun livre trouvé</h3>
                            <p class="text-gray-500 mb-6">
                                @if(request('q'))
                                    Aucun résultat pour "<span class="font-semibold text-indigo-600">{{ request('q') }}</span>". Essayez une autre recherche.
                                @else
                                    Le catalogue est vide. Commencez par ajouter des ouvrages.
                                @endif
                            </p>
                            @if(!request('q'))
                            <a href="{{ route('books.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300">
                                <i class="fas fa-plus-circle"></i>
                                <span>Ajouter le premier livre</span>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if(method_exists($books, 'links'))
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-500">
                <i class="fas fa-database mr-1"></i>
                Total : <span class="font-bold text-indigo-600">{{ $books->total() }}</span> livre(s)
            </div>
            <div class="pagination">
                {{ $books->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Bouton mobile pour ajouter un livre -->
<div class="lg:hidden mt-6">
    <a href="{{ route('books.create') }}" class="block w-full bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 text-white font-semibold px-6 py-4 rounded-xl shadow-lg text-center">
        <i class="fas fa-plus-circle mr-2"></i>Ajouter un livre
    </a>
</div>

<!-- Pied de page personnalisé -->
<div class="mt-8 text-center text-gray-500 text-sm">
    <p class="flex items-center justify-center gap-2">
        <i class="fas fa-code text-indigo-600"></i>
        Développé par <span class="font-semibold text-indigo-600">AZOUTSA ZONSOP OVIANE ARELLE</span>
        <span class="text-gray-300">|</span>
        IAI Cameroun - Génie Logiciel 2026
    </p>
</div>
@endsection

@push('scripts')
<script>
    // Confirmation pour les suppressions
    document.querySelectorAll('form[data-confirm]').forEach(form => {
        form.addEventListener('submit', function(e) {
            const message = this.getAttribute('data-confirm') || 'Êtes-vous sûr ?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush