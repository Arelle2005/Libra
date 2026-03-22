{{-- resources/views/books/create.blade.php --}}
{{-- Formulaire de création d'un livre --}}

@extends('app.master')

@section('title', 'Ajouter un Livre - Libra')

@section('content')
<!-- En-tête avec Logo IAI -->
<div class="mb-8 bg-gradient-to-r from-indigo-900 via-purple-900 to-slate-900 rounded-2xl shadow-xl p-8 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
    
    <div class="relative z-10 flex items-center gap-6">
        <!-- Logo IAI Cameroun -->
        <div class="bg-white rounded-xl p-3 shadow-lg">
            <img src="https://www.iaicameroun.com/wp-content/uploads/2021/09/logo-iai.png" 
                 alt="IAI Cameroun" 
                 class="h-16 w-auto object-contain">
        </div>
        <div>
            <h1 class="text-4xl font-bold text-white mb-2 tracking-tight">
                <i class="fas fa-book mr-3 text-teal-400"></i>Ajouter un Nouveau Livre
            </h1>
            <p class="text-indigo-200 text-lg">Institut Africain d'Informatique - Centre d'Excellence Technologique Paul Biya</p>
            <p class="text-indigo-300 text-sm mt-1">
                <i class="fas fa-edit mr-2"></i>Remplissez les informations de l'ouvrage
            </p>
        </div>
    </div>
</div>

<!-- Formulaire avec design moderne -->
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <!-- En-tête du formulaire -->
        <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-800 px-8 py-6">
            <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                <div class="bg-white/20 p-3 rounded-xl">
                    <i class="fas fa-book-open text-2xl"></i>
                </div>
                <span>Informations du Livre</span>
            </h2>
            <p class="text-indigo-200 text-sm mt-2 ml-14">
                <i class="fas fa-info-circle mr-1"></i>Tous les champs marqués d'une * sont obligatoires
            </p>
        </div>

        <!-- Corps du formulaire -->
        <div class="px-8 py-8">
            <form method="POST" action="{{ route('books.store') }}" class="space-y-6">
                @csrf
                
                <!-- Titre du livre -->
                <div class="group">
                    <label class="block text-gray-700 text-sm font-bold mb-2 flex items-center gap-2">
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-2 rounded-lg">
                            <i class="fas fa-font text-white text-sm"></i>
                        </div>
                        <span>Titre du livre *</span>
                    </label>
                    <input type="text" name="title" value="{{ old('title') }}" required 
                           placeholder="Ex: Python Crash Course"
                           class="w-full pl-4 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all text-gray-700 font-medium @error('title') border-rose-500 @enderror">
                    @error('title')
                    <p class="text-xs text-rose-600 mt-1 ml-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1 ml-1">
                        <i class="fas fa-info-circle mr-1"></i>Le titre complet de l'ouvrage
                    </p>
                </div>

                <!-- Auteur -->
                <div class="group">
                    <label class="block text-gray-700 text-sm font-bold mb-2 flex items-center gap-2">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-2 rounded-lg">
                            <i class="fas fa-pen-fancy text-white text-sm"></i>
                        </div>
                        <span>Auteur *</span>
                    </label>
                    <input type="text" name="author" value="{{ old('author') }}" required 
                           placeholder="Ex: Eric Matthes"
                           class="w-full pl-4 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all text-gray-700 font-medium @error('author') border-rose-500 @enderror">
                    @error('author')
                    <p class="text-xs text-rose-600 mt-1 ml-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1 ml-1">
                        <i class="fas fa-info-circle mr-1"></i>Nom complet de l'auteur
                    </p>
                </div>

                <!-- ISBN -->
                <div class="group">
                    <label class="block text-gray-700 text-sm font-bold mb-2 flex items-center gap-2">
                        <div class="bg-gradient-to-r from-teal-500 to-emerald-600 p-2 rounded-lg">
                            <i class="fas fa-barcode text-white text-sm"></i>
                        </div>
                        <span>ISBN *</span>
                    </label>
                    <input type="text" name="isbn" value="{{ old('isbn') }}" required maxlength="13" 
                           placeholder="Ex: 9782412048993"
                           class="w-full pl-4 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-100 transition-all text-gray-700 font-medium @error('isbn') border-rose-500 @enderror">
                    @error('isbn')
                    <p class="text-xs text-rose-600 mt-1 ml-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1 ml-1">
                        <i class="fas fa-info-circle mr-1"></i>Code ISBN à 13 caractères
                    </p>
                </div>

                <!-- Nombre d'exemplaires -->
                <div class="group">
                    <label class="block text-gray-700 text-sm font-bold mb-2 flex items-center gap-2">
                        <div class="bg-gradient-to-r from-orange-500 to-coral-600 p-2 rounded-lg">
                            <i class="fas fa-boxes text-white text-sm"></i>
                        </div>
                        <span>Nombre d'exemplaires *</span>
                    </label>
                    <input type="number" name="total_copies" value="{{ old('total_copies', 1) }}" min="1" required 
                           placeholder="Ex: 3"
                           class="w-full pl-4 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all text-gray-700 font-medium @error('total_copies') border-rose-500 @enderror">
                    @error('total_copies')
                    <p class="text-xs text-rose-600 mt-1 ml-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1 ml-1">
                        <i class="fas fa-info-circle mr-1"></i>Nombre total d'exemplaires disponibles
                    </p>
                </div>

                <!-- Date de publication -->
                <div class="group">
                    <label class="block text-gray-700 text-sm font-bold mb-2 flex items-center gap-2">
                        <div class="bg-gradient-to-r from-rose-500 to-pink-600 p-2 rounded-lg">
                            <i class="fas fa-calendar-alt text-white text-sm"></i>
                        </div>
                        <span>Date de publication</span>
                    </label>
                    <input type="date" name="published_date" value="{{ old('published_date') }}" 
                           class="w-full pl-4 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 focus:ring-4 focus:ring-rose-100 transition-all text-gray-700 font-medium">
                    @error('published_date')
                    <p class="text-xs text-rose-600 mt-1 ml-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1 ml-1">
                        <i class="fas fa-info-circle mr-1"></i>Optionnel - Date de première publication
                    </p>
                </div>

                <!-- Description -->
                <div class="group">
                    <label class="block text-gray-700 text-sm font-bold mb-2 flex items-center gap-2">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-2 rounded-lg">
                            <i class="fas fa-align-left text-white text-sm"></i>
                        </div>
                        <span>Description</span>
                    </label>
                    <textarea name="description" rows="4" 
                              placeholder="Brève description du contenu du livre..."
                              class="w-full pl-4 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all text-gray-700 font-medium @error('description') border-rose-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-xs text-rose-600 mt-1 ml-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Boutons d'action -->
                <div class="flex flex-col md:flex-row gap-4 pt-6 border-t border-gray-200">
                    <button type="submit" 
                            class="group flex-1 bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-800 hover:from-indigo-700 hover:via-purple-700 hover:to-indigo-900 text-white font-bold py-4 px-4 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-3">
                        <i class="fas fa-save text-lg group-hover:rotate-12 transition-transform"></i>
                        <span>Enregistrer le livre</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                    <a href="{{ route('books.index') }}" 
                       class="group flex-1 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold py-4 px-4 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300 flex items-center justify-center gap-3">
                        <i class="fas fa-times text-lg group-hover:rotate-12 transition-transform"></i>
                        <span>Annuler</span>
                        <i class="fas fa-arrow-left ml-2 group-hover:-translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </form>
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