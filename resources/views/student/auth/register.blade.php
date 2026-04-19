{{-- resources/views/student/auth/register.blade.php --}}
{{-- Page d'inscription pour les étudiants/emprunteurs --}}

@extends('app.master')

@section('title', 'Inscription Étudiant - Libra')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-900 via-purple-900 to-slate-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        
        <!-- En-tête avec Logo IAI -->
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <div class="bg-white rounded-xl p-4 shadow-lg">
                    <img src="{{ asset('images/logoIAI.webp') }}" 
                         alt="IAI Cameroun" 
                         class="h-20 w-auto object-contain">
                </div>
            </div>
            <h2 class="text-3xl font-bold text-white">
                <i class="fas fa-user-plus mr-2 text-teal-400"></i>
                Inscription Étudiant
            </h2>
            <p class="mt-2 text-indigo-200">
                Institut Africain d'Informatique - Centre d'Excellence Technologique Paul Biya
            </p>
        </div>

        <!-- Formulaire d'inscription -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            
            <!-- Message de succès -->
            @if(session('success'))
            <div class="mb-4 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded">
                <p class="text-emerald-700">{{ session('success') }}</p>
            </div>
            @endif

            <form method="POST" action="{{ route('student.register') }}" class="space-y-4">
                @csrf
                
                <!-- Nom complet -->
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-indigo-500"></i>Nom complet
                    </label>
                    <input id="name" name="name" type="text" required 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('name') border-rose-500 @enderror"
                           placeholder="Ex: Azoutsa Oviane">
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Matricule -->
                <div>
                    <label for="matricule" class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-id-badge mr-2 text-indigo-500"></i>Matricule
                    </label>
                    <input id="matricule" name="matricule" type="text" required 
                           value="{{ old('matricule') }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('matricule') border-rose-500 @enderror"
                           placeholder="Ex: IAI2023GL001">
                    @error('matricule')
                        <p class="text-xs text-rose-600 mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-indigo-500"></i>Email
                    </label>
                    <input id="email" name="email" type="email" required 
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('email') border-rose-500 @enderror"
                           placeholder="etudiant@iai.cm">
                    @error('email')
                        <p class="text-xs text-rose-600 mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Téléphone -->
                <div>
                    <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-phone mr-2 text-indigo-500"></i>Téléphone (optionnel)
                    </label>
                    <input id="phone" name="phone" type="text" 
                           value="{{ old('phone') }}"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('phone') border-rose-500 @enderror"
                           placeholder="Ex: 670000001">
                    @error('phone')
                        <p class="text-xs text-rose-600 mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Type d'emprunteur -->
                <div>
                    <label for="type" class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-tag mr-2 text-indigo-500"></i>Type
                    </label>
                    <select id="type" name="type" required 
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('type') border-rose-500 @enderror">
                        <option value="">-- Sélectionner un type --</option>
                        <option value="student" {{ old('type')=='student'?'selected':'' }}>🎓 Étudiant</option>
                        <option value="teacher" {{ old('type')=='teacher'?'selected':'' }}>👨‍🏫 Enseignant</option>
                        <option value="staff" {{ old('type')=='staff'?'selected':'' }}>👔 Personnel</option>
                    </select>
                    @error('type')
                        <p class="text-xs text-rose-600 mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-indigo-500"></i>Mot de passe
                    </label>
                    <input id="password" name="password" type="password" required 
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('password') border-rose-500 @enderror"
                           placeholder="••••••••">
                    @error('password')
                        <p class="text-xs text-rose-600 mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Confirmation du mot de passe -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-indigo-500"></i>Confirmer le mot de passe
                    </label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                           placeholder="••••••••">
                </div>

                <!-- Bouton d'inscription -->
                <div>
                    <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300">
                        <i class="fas fa-user-plus mr-2"></i>S'inscrire
                    </button>
                </div>

                <!-- Lien vers connexion -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Déjà un compte ? 
                        <a href="{{ route('student.login') }}" class="font-bold text-indigo-600 hover:text-indigo-800">
                            Se connecter
                        </a>
                    </p>
                </div>

                <!-- Retour accueil bibliothécaire -->
                <div class="text-center pt-4 border-t">
                    <p class="text-xs text-gray-500">
                        Vous êtes bibliothécaire ? 
                        <a href="{{ route('login') }}" class="font-bold text-gray-700 hover:text-gray-900">
                            Connexion personnel
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center text-indigo-200 text-sm">
            <p><i class="fas fa-code text-teal-400"></i> Développé par <span class="font-semibold">AZOUTSA ZONSOP OVIANE ARELLE</span> | IAI Cameroun 2026</p>
        </div>
    </div>
</div>
@endsection

