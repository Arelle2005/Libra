{{-- resources/views/student/auth/login.blade.php --}}
{{-- Page de connexion pour les étudiants/emprunteurs --}}

@extends('app.master')

@section('title', 'Connexion Étudiant - Libra')

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
                <i class="fas fa-user-graduate mr-2 text-teal-400"></i>
                Espace Étudiant
            </h2>
            <p class="mt-2 text-indigo-200">
                Institut Africain d'Informatique - Centre d'Excellence Technologique Paul Biya
            </p>
        </div>

        <!-- Formulaire de connexion -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            
            <!-- Message de succès -->
            @if(session('success'))
            <div class="mb-4 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded">
                <p class="text-emerald-700">{{ session('success') }}</p>
            </div>
            @endif

            <form method="POST" action="{{ route('student.login') }}" class="space-y-6">
                @csrf
                
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

                <!-- Bouton de connexion -->
                <div>
                    <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300">
                        <i class="fas fa-sign-in-alt mr-2"></i>Se connecter
                    </button>
                </div>

                <!-- Lien vers inscription -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Pas encore de compte ? 
                        <a href="{{ route('student.register') }}" class="font-bold text-indigo-600 hover:text-indigo-800">
                            S'inscrire
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