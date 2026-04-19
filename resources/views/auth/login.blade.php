{{-- resources/views/auth/login.blade.php --}}
{{-- Page de connexion - Bibliothécaires (Libra) --}}

<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- En-tête avec Logo IAI -->
    <div class="mb-8 text-center">
        <div class="inline-block bg-white rounded-2xl p-4 shadow-xl mb-4">
            <img src="{{ asset('images/logoIAI.webp') }}" 
                 alt="IAI Cameroun" 
                 class="h-20 w-auto object-contain">
        </div>
        <h2 class="text-3xl font-bold text-gray-800 mb-2">
            <i class="fas fa-book-open text-indigo-600 mr-2"></i>Libra
        </h2>
        <p class="text-gray-600 text-sm">
            Institut Africain d'Informatique - Centre d'Excellence Technologique Paul Biya
        </p>
        <p class="text-gray-500 text-xs mt-1">
            <i class="fas fa-user-shield mr-1"></i>Espace Bibliothécaire
        </p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold" />
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-400"></i>
                </div>
                <x-text-input id="email" 
                              class="block w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100" 
                              type="email" 
                              name="email" 
                              :value="old('email')" 
                              required 
                              autofocus 
                              autocomplete="username" 
                              placeholder="biblio@iai.cm" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" class="text-gray-700 font-semibold" />

            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
                <x-text-input id="password" 
                              class="block w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100"
                              type="password"
                              name="password"
                              required 
                              autocomplete="current-password"
                              placeholder="••••••••" />
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" 
                       type="checkbox" 
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 w-4 h-4" 
                       name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
            </label>
        </div>

        <!-- Login Button -->
        <div class="mt-6">
            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-sign-in-alt mr-2"></i>{{ __('Se connecter') }}
            </button>
        </div>

        <!-- Forgot Password & Student Link -->
        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-indigo-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
                   href="{{ route('password.request') }}">
                    <i class="fas fa-key mr-1"></i>{{ __('Mot de passe oublié ?') }}
                </a>
            @endif

            <!-- Lien vers espace étudiant -->
            <a href="{{ route('student.login') }}" 
               class="text-sm text-indigo-600 hover:text-indigo-800 font-semibold">
                <i class="fas fa-user-graduate mr-1"></i>Espace Étudiant
            </a>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-gray-500 text-xs">
            <p><i class="fas fa-code text-indigo-600"></i> Développé par <span class="font-semibold">AZOUTSA ZONSOP OVIANE ARELLE</span> | IAI Cameroun 2026</p>
        </div>
    </form>
</x-guest-layout>