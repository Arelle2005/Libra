{{-- resources/views/borrows/create.blade.php --}}
{{-- Formulaire de nouvel emprunt --}}

@extends('app.master')

@section('title', 'Nouvel Emprunt - Libra')

@section('content')
<!-- En-tête avec Logo IAI -->
<div class="mb-8 bg-gradient-to-r from-indigo-900 via-purple-900 to-slate-900 rounded-2xl shadow-xl p-8 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
    
    <div class="relative z-10 flex items-center gap-6">
        <div class="bg-white rounded-xl p-3 shadow-lg">
            <img src="https://www.iaicameroun.com/wp-content/uploads/2021/09/logo-iai.png" 
                 alt="IAI Cameroun" 
                 class="h-16 w-auto object-contain">
        </div>
        <div>
            <h1 class="text-4xl font-bold text-white mb-2 tracking-tight">
                <i class="fas fa-hand-holding mr-3 text-teal-400"></i>Nouvel Emprunt
            </h1>
            <p class="text-indigo-200 text-lg">Institut Africain d'Informatique - Centre d'Excellence Technologique Paul Biya</p>
            <p class="text-indigo-300 text-sm mt-1">
                <i class="fas fa-book-reader mr-2"></i>Enregistrer un prêt de livre
            </p>
        </div>
    </div>
</div>

<!-- Formulaire -->
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <!-- En-tête du formulaire -->
        <div class="bg-gradient-to-r from-purple-600 via-pink-600 to-purple-800 px-8 py-6">
            <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                <div class="bg-white/20 p-3 rounded-xl"><i class="fas fa-file-contract text-2xl"></i></div>
                <span>Formulaire de Prêt</span>
            </h2>
            <p class="text-purple-100 text-sm mt-2 ml-14"><i class="fas fa-info-circle mr-1"></i>Tous les champs marqués * sont obligatoires</p>
        </div>

        <div class="px-8 py-8">
            <form method="POST" action="{{ route('borrows.store') }}" class="space-y-6">
                @csrf
                
                <!-- Livre -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2"><i class="fas fa-book mr-2 text-indigo-500"></i>Livre *</label>
                    <select name="book_id" required class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-indigo-500 @error('book_id') border-rose-500 @enderror">
                        <option value="">-- Sélectionner un livre --</option>
                        @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ old('book_id')==$book->id?'selected':'' }}>
                            {{ $book->title }} ({{ $book->available_copies }} disponible(s))
                        </option>
                        @endforeach
                    </select>
                    @error('book_id')<p class="text-xs text-rose-600 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                </div>

                <!-- Emprunteur -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2"><i class="fas fa-user-graduate mr-2 text-purple-500"></i>Emprunteur *</label>
                    <select name="borrower_id" required class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-purple-500 @error('borrower_id') border-rose-500 @enderror">
                        <option value="">-- Sélectionner un emprunteur --</option>
                        @foreach($borrowers as $borrower)
                        <option value="{{ $borrower->id }}" {{ old('borrower_id')==$borrower->id?'selected':'' }}>
                            {{ $borrower->name }} ({{ $borrower->matricule }})
                        </option>
                        @endforeach
                    </select>
                    @error('borrower_id')<p class="text-xs text-rose-600 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                </div>

                <!-- Durée du prêt -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2"><i class="fas fa-calendar-alt mr-2 text-teal-500"></i>Durée du prêt (jours) *</label>
                    <input type="number" name="duration" value="14" min="1" max="30" required 
                           class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-teal-500 @error('duration') border-rose-500 @enderror">
                    @error('duration')<p class="text-xs text-rose-600 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                    <p class="text-xs text-gray-500 mt-1"><i class="fas fa-info-circle mr-1"></i>La date de retour sera calculée automatiquement (1 à 30 jours)</p>
                </div>

                <!-- Résumé -->
                <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-100">
                    <h3 class="text-sm font-bold text-gray-800 mb-2"><i class="fas fa-clipboard-check text-indigo-600 mr-2"></i>Résumé</h3>
                    <ul class="text-xs text-gray-600 space-y-1 ml-6">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Le stock du livre sera décrémenté</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Date d'échéance calculée automatiquement</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Notification en cas de retard</li>
                    </ul>
                </div>

                <!-- Boutons -->
                <div class="flex gap-4 pt-6 border-t">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg">
                        <i class="fas fa-save mr-2"></i>Enregistrer l'emprunt
                    </button>
                    <a href="{{ route('borrows.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-4 rounded-xl text-center">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="mt-8 text-center text-gray-500 text-sm">
    <p><i class="fas fa-code text-indigo-600"></i> Développé par <span class="font-semibold">AZOUTSA ZONSOP OVIANE ARELLE</span> | IAI Cameroun 2026</p>
</div>
@endsection