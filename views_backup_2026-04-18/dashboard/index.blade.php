{{-- resources/views/dashboard/index.blade.php --}}
{{-- Tableau de bord avec statistiques --}}

@extends('app.master')

@section('title', 'Tableau de bord - Libra')

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
                    <i class="fas fa-chart-line mr-3 text-teal-400"></i>Tableau de Bord
                </h1>
                <p class="text-indigo-200 text-lg">Institut Africain d'Informatique - Centre d'Excellence Technologique Paul Biya</p>
                <p class="text-indigo-300 text-sm mt-1">
                    <i class="fas fa-user-circle mr-2"></i>Bienvenue, <span class="font-semibold text-white">{{ Auth::user()->name ?? 'Bibliothécaire' }}</span>
                </p>
            </div>
        </div>
        <div class="hidden lg:block text-right">
            <p class="text-indigo-200 text-sm">Gestion Bibliothèque Universitaire</p>
            <p class="text-white font-semibold text-lg">Année Académique 2025-2026</p>
        </div>
    </div>
</div>

<!-- Cartes de statistiques -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Livres - Couleur Indigo/Violet -->
    <div class="group bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-indigo-100 text-sm font-medium uppercase tracking-wider">Total Livres</p>
                <p class="text-5xl font-bold mt-2">{{ $booksCount ?? 0 }}</p>
                <p class="text-indigo-200 text-xs mt-2">
                    <i class="fas fa-arrow-up mr-1"></i>Catalogue complet
                </p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl group-hover:bg-white/30 transition-all">
                <i class="fas fa-book-open text-4xl"></i>
            </div>
        </div>
    </div>

    <!-- Emprunteurs - Couleur Teal/Turquoise -->
    <div class="group bg-gradient-to-br from-teal-500 to-emerald-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-teal-100 text-sm font-medium uppercase tracking-wider">Emprunteurs</p>
                <p class="text-5xl font-bold mt-2">{{ $borrowersCount ?? 0 }}</p>
                <p class="text-teal-200 text-xs mt-2">
                    <i class="fas fa-user-graduate mr-1"></i>Étudiants & Profs
                </p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl group-hover:bg-white/30 transition-all">
                <i class="fas fa-users text-4xl"></i>
            </div>
        </div>
    </div>

    <!-- Emprunts en cours - Couleur Orange/Coral -->
    <div class="group bg-gradient-to-br from-orange-500 to-coral-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-sm font-medium uppercase tracking-wider">En Cours</p>
                <p class="text-5xl font-bold mt-2">{{ $activeBorrows ?? 0 }}</p>
                <p class="text-orange-200 text-xs mt-2">
                    <i class="fas fa-clock mr-1"></i>Prêts actifs
                </p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl group-hover:bg-white/30 transition-all">
                <i class="fas fa-exchange-alt text-4xl"></i>
            </div>
        </div>
    </div>

    <!-- Retards - Couleur Rose/Rouge -->
    <div class="group bg-gradient-to-br from-rose-500 to-pink-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-rose-100 text-sm font-medium uppercase tracking-wider">Retards</p>
                <p class="text-5xl font-bold mt-2">{{ $lateBorrows ?? 0 }}</p>
                <p class="text-rose-200 text-xs mt-2">
                    <i class="fas fa-exclamation-circle mr-1"></i>Action requise
                </p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl group-hover:bg-white/30 transition-all">
                <i class="fas fa-bell text-4xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Section principale : Emprunts récents + Actions rapides -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Emprunts récents (2/3 de la largeur) -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-slate-800 to-slate-900 px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-bold text-white">
                <i class="fas fa-history mr-2 text-teal-400"></i>Emprunts Récents
            </h2>
            <a href="{{ route('borrows.index') }}" class="text-teal-400 hover:text-teal-300 text-sm font-semibold transition-colors">
                Voir tout <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Livre</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Emprunteur</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentBorrows ?? [] as $borrow)
                    <tr class="hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                                    <i class="fas fa-book text-indigo-600"></i>
                                </div>
                                <span class="text-sm font-semibold text-gray-800">{{ $borrow->book->title ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="bg-teal-100 p-2 rounded-lg mr-3">
                                    <i class="fas fa-user text-teal-600"></i>
                                </div>
                                <span class="text-sm text-gray-600">{{ $borrow->borrower->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <i class="far fa-calendar-alt mr-2 text-gray-400"></i>{{ $borrow->borrowed_at->format('d/m/Y') ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                                @if($borrow->status === 'active') bg-amber-100 text-amber-700 border border-amber-200
                                @elseif($borrow->status === 'returned') bg-emerald-100 text-emerald-700 border border-emerald-200
                                @else bg-rose-100 text-rose-700 border border-rose-200 @endif">
                                @if($borrow->status === 'overdue') <i class="fas fa-exclamation-triangle mr-1"></i>@endif
                                {{ $borrow->status === 'active' ? 'En cours' : ($borrow->status === 'returned' ? 'Rendu' : 'Retard') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="text-gray-400 mb-3">
                                <i class="fas fa-inbox text-5xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Aucun emprunt récent</p>
                            <p class="text-gray-400 text-sm mt-1">Les nouveaux emprunts apparaîtront ici</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Actions rapides (1/3 de la largeur) -->
    <div class="lg:col-span-1 space-y-4">
        <div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-indigo-800 rounded-2xl shadow-xl p-6 text-white">
            <h3 class="text-lg font-bold mb-4 flex items-center">
                <i class="fas fa-bolt mr-2 text-yellow-300"></i>Actions Rapides
            </h3>
            
            <div class="space-y-3">
                <a href="{{ route('books.create') }}" class="group flex items-center bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-xl p-4 transition-all duration-300 border border-white/10 hover:border-white/30">
                    <div class="bg-white/20 p-3 rounded-xl group-hover:scale-110 transition-transform">
                        <i class="fas fa-plus-circle text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="font-semibold">Ajouter un livre</p>
                        <p class="text-xs text-indigo-200">Nouvel ouvrage</p>
                    </div>
                    <i class="fas fa-chevron-right ml-auto text-indigo-300 group-hover:translate-x-1 transition-transform"></i>
                </a>

                <a href="{{ route('borrowers.create') }}" class="group flex items-center bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-xl p-4 transition-all duration-300 border border-white/10 hover:border-white/30">
                    <div class="bg-white/20 p-3 rounded-xl group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-plus text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="font-semibold">Nouvel emprunteur</p>
                        <p class="text-xs text-indigo-200">Étudiant/Enseignant</p>
                    </div>
                    <i class="fas fa-chevron-right ml-auto text-indigo-300 group-hover:translate-x-1 transition-transform"></i>
                </a>

                <a href="{{ route('borrows.create') }}" class="group flex items-center bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-xl p-4 transition-all duration-300 border border-white/10 hover:border-white/30">
                    <div class="bg-white/20 p-3 rounded-xl group-hover:scale-110 transition-transform">
                        <i class="fas fa-hand-holding text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="font-semibold">Nouvel emprunt</p>
                        <p class="text-xs text-indigo-200">Enregistrer un prêt</p>
                    </div>
                    <i class="fas fa-chevron-right ml-auto text-indigo-300 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Carte d'information -->
        <div class="bg-gradient-to-br from-teal-500 to-emerald-600 rounded-2xl shadow-xl p-6 text-white">
            <div class="flex items-start gap-4">
                <div class="bg-white/20 p-3 rounded-xl">
                    <i class="fas fa-info-circle text-2xl"></i>
                </div>
                <div>
                    <h4 class="font-bold mb-2">Information</h4>
                    <p class="text-sm text-teal-100">
                        Durée de prêt standard : <span class="font-bold text-white">14 jours</span>
                    </p>
                    <p class="text-sm text-teal-100 mt-1">
                        Renouvellement possible sur demande
                    </p>
                </div>
            </div>
        </div>
    </div>
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