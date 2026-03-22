{{-- resources/views/app/footer.blade.php --}}
{{-- Pied de page réutilisable pour toutes les pages --}}

<footer class="bg-slate-900 text-white py-8 mt-auto border-t-4 border-teal-500">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            {{-- Section 1 : Informations --}}
            <div>
                <h3 class="text-lg font-bold text-teal-400 mb-3">
                    <i class="fas fa-book-reader mr-2"></i>Libra
                </h3>
                <p class="text-sm text-gray-300">
                    Application de gestion de bibliothèque universitaire développée avec Laravel et MySQL.
                </p>
                <p class="text-xs text-gray-400 mt-2">
                    <i class="fas fa-university mr-1"></i>
                    Institut Africain d'Informatique - Cameroun
                </p>
            </div>

            {{-- Section 2 : Liens Rapides --}}
            <div>
                <h3 class="text-lg font-bold text-teal-400 mb-3">
                    <i class="fas fa-link mr-2"></i>Liens Rapides
                </h3>
                <ul class="text-sm text-gray-300 space-y-2">
                    <li>
                        <a href="{{ route('dashboard') }}" class="hover:text-teal-400 transition">
                            <i class="fas fa-chevron-right mr-1"></i>Tableau de bord
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('books.index') }}" class="hover:text-teal-400 transition">
                            <i class="fas fa-chevron-right mr-1"></i>Catalogue des livres
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('borrowers.index') }}" class="hover:text-teal-400 transition">
                            <i class="fas fa-chevron-right mr-1"></i>Emprunteurs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('borrows.index') }}" class="hover:text-teal-400 transition">
                            <i class="fas fa-chevron-right mr-1"></i>Historique des emprunts
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Section 3 : Contact & Crédits --}}
            <div>
                <h3 class="text-lg font-bold text-teal-400 mb-3">
                    <i class="fas fa-envelope mr-2"></i>Contact
                </h3>
                <ul class="text-sm text-gray-300 space-y-2">
                    <li>
                        <i class="fas fa-globe mr-2 text-teal-400"></i>
                        <a href="https://www.iaicameroun.com" target="_blank" class="hover:text-teal-400 transition">
                            www.iaicameroun.com
                        </a>
                    </li>
                    <li>
                        <i class="fas fa-envelope mr-2 text-teal-400"></i>
                        info@iaicameroun.com
                    </li>
                    <li>
                        <i class="fas fa-phone mr-2 text-teal-400"></i>
                        (+237) 242 72 99 57
                    </li>
                </ul>
                
                {{-- Crédits Développeur --}}
                <div class="mt-4 pt-4 border-t border-gray-700">
                    <p class="text-xs text-gray-400">
                        <i class="fas fa-code text-teal-400 mr-1"></i>
                        Développé par <span class="text-white font-semibold">AZOUTSA ZONSOP OVIANE ARELLE</span>
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                        IAI Cameroun - Génie Logiciel 2026
                    </p>
                    <p class="text-xs text-gray-500">
                        Encadreur : M. MBIA
                    </p>
                </div>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="mt-6 pt-6 border-t border-gray-700 text-center">
            <p class="text-sm text-gray-400">
                &copy; {{ date('Y') }} Libra - Gestion Bibliothèque Universitaire. Tous droits réservés.
            </p>
            <p class="text-xs text-gray-500 mt-1">
                <i class="fas fa-shield-alt mr-1"></i>
                Application sécurisée par Laravel {{ app()->version() }}
            </p>
        </div>
    </div>
</footer>