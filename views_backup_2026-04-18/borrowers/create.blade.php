{{-- resources/views/borrowers/create.blade.php --}}
{{-- Formulaire d'ajout d'un emprunteur --}}

@extends('app.master')

@section('title', 'Nouvel Emprunteur - Libra')

@section('content')
<!-- En-tête -->
<div class="mb-8 bg-gradient-to-r from-indigo-900 via-purple-900 to-slate-900 rounded-2xl shadow-xl p-8">
    <div class="flex items-center gap-6">
        <div class="bg-white rounded-xl p-3 shadow-lg">
            <img src="{{ asset('images/logoiai.webp') }}" alt="IAI Cameroun" class="h-16 w-auto object-contain">
        </div>
        <div>
            <h1 class="text-4xl font-bold text-white mb-2">
                <i class="fas fa-user-plus mr-3 text-teal-400"></i>Nouvel Emprunteur
            </h1>
            <p class="text-indigo-200">Institut Africain d'Informatique</p>
        </div>
    </div>
</div>

<!-- Formulaire -->
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- En-tête du formulaire -->
        <div class="bg-teal-600 px-8 py-6">
            <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                <div class="bg-white/20 p-3 rounded-xl"><i class="fas fa-id-card text-2xl"></i></div>
                <span>Informations de l'Emprunteur</span>
            </h2>
            <p class="text-teal-100 text-sm mt-2 ml-14"><i class="fas fa-info-circle mr-1"></i>Tous les champs * sont obligatoires</p>
        </div>

        <div class="px-8 py-8">
            <form method="POST" action="{{ route('borrowers.store') }}" class="space-y-6">
                @csrf
                
                <!-- Nom complet -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2"><i class="fas fa-user mr-2 text-indigo-500"></i>Nom complet *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Ex: Jean Dupont"
                           class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-indigo-500 @error('name') border-rose-500 @enderror">
                    @error('name')<p class="text-xs text-rose-600 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                </div>

                <!-- Matricule -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2"><i class="fas fa-id-badge mr-2 text-purple-500"></i>Matricule *</label>
                    <input type="text" name="matricule" value="{{ old('matricule') }}" required placeholder="Ex: IAI2023GL001"
                           class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-purple-500 @error('matricule') border-rose-500 @enderror">
                    @error('matricule')<p class="text-xs text-rose-600 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2"><i class="fas fa-envelope mr-2 text-teal-500"></i>Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="Ex: jean@iai.cm"
                           class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-teal-500 @error('email') border-rose-500 @enderror">
                    @error('email')<p class="text-xs text-rose-600 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                </div>

                <!-- Téléphone -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2"><i class="fas fa-phone mr-2 text-orange-500"></i>Téléphone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Ex: 670000001"
                           class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-orange-500">
                </div>

                <!-- Type d'emprunteur -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2"><i class="fas fa-tag mr-2 text-rose-500"></i>Type *</label>
                    <select name="type" required class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-rose-500">
                        <option value="">-- Sélectionner un type --</option>
                        <option value="student" {{ old('type')=='student'?'selected':'' }}>🎓 Étudiant</option>
                        <option value="teacher" {{ old('type')=='teacher'?'selected':'' }}>👨‍🏫 Enseignant</option>
                        <option value="staff" {{ old('type')=='staff'?'selected':'' }}>👔 Personnel</option>
                    </select>
                    @error('type')<p class="text-xs text-rose-600 mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
                </div>

                <!-- Boutons -->
                <div class="flex gap-4 pt-6 border-t">
                    <button type="submit" class="flex-1 bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg">
                        <i class="fas fa-save mr-2"></i>Enregistrer
                    </button>
                    <a href="{{ route('borrowers.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-4 rounded-xl text-center">
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