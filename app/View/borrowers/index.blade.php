{{-- resources/views/borrowers/index.blade.php --}}
{{-- Liste des emprunteurs avec recherche et filtrage --}}

@extends('app.master')

@section('title', 'Emprunteurs - Libra')

@section('content')
<!-- En-tête avec Logo IAI -->
<div class="mb-8 bg-gradient-to-r from-indigo-900 via-purple-900 to-slate-900 rounded-2xl shadow-xl p-8 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
    
    <div class="relative z-10 flex items-center justify-between">
        <div class="flex items-center gap-6">
            <div class="bg-white rounded-xl p-3 shadow-lg">
                <img src="https://www.iaicameroun.com/wp-content/uploads/2021/09/logo-iai.png" 
                     alt="IAI Cameroun" 
                     class="h-16 w-auto object-contain">
            </div>
            <div>
                <h1 class="text-4xl font-bold text-white mb-2 tracking-tight">
                    <i class="fas fa-users mr-3 text-teal-400"></i>Emprunteurs
                </h1>
                <p class="text-indigo-200 text-lg">Institut Africain d'Informatique - Centre d'Excellence Technologique Paul Biya</p>
                <p class="text-indigo-300 text-sm mt-1">
                    <i class="fas fa-layer-group mr-2"></i>{{ $borrowers->total() ?? 0 }} emprunteur(s) enregistré(s)
                </p>
            </div>
        </div>
        <div class="hidden lg:block">
            <a href="{{ route('borrowers.create') }}" class="group inline-flex items-center gap-2 bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-user-plus text-xl group-hover:rotate-90 transition-transform"></i>
                <span>Nouvel emprunteur</span>
            </a>
        </div>
    </div>
</div>

<!-- Barre de recherche -->
<div class="bg-gradient-to-r from-white to-gray-50 rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
    <form method="get" action="{{ route('borrowers.index') }}" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1 relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400 text-lg"></i>
            </div>
            <input type="text" name="q" value="{{ request('q') }}" 
                   placeholder="Rechercher par nom, matricule ou email..." 
                   class="w-full pl-12 pr-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all text-gray-700 font-medium">
        </div>
        <select name="type" class="px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:outline-none focus:border-indigo-500">
            <option value="">Tous les types</option>
            <option value="student" {{ request('type')=='student'?'selected':'' }}>Étudiants</option>
            <option value="teacher" {{ request('type')=='teacher'?'selected':'' }}>Enseignants</option>
            <option value="staff" {{ request('type')=='staff'?'selected':'' }}>Personnel</option>
        </select>
        <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold px-8 py-3 rounded-xl shadow-md">
            <i class="fas fa-search"></i> Rechercher
        </button>
        @if(request('q') || request('type'))
        <a href="{{ route('borrowers.index') }}" class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold px-8 py-3 rounded-xl shadow-md">
            <i class="fas fa-times"></i> Effacer
        </a>
        @endif
    </form>
</div>

<!-- Liste des emprunteurs -->
<div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
    <div class="bg-gradient-to-r from-slate-800 to-slate-900 px-6 py-4">
        <h2 class="text-xl font-bold text-white flex items-center gap-2">
            <i class="fas fa-table text-teal-400"></i>Liste des Emprunteurs
        </h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-indigo-100">
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase"><i class="fas fa-user mr-2 text-indigo-500"></i>Nom</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase"><i class="fas fa-id-badge mr-2 text-purple-500"></i>Matricule</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase"><i class="fas fa-envelope mr-2 text-teal-500"></i>Email</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase"><i class="fas fa-tag mr-2 text-orange-500"></i>Type</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase"><i class="fas fa-cog mr-2 text-gray-500"></i>Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($borrowers as $borrower)
                <tr class="group hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition-all">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-3 rounded-xl">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <span class="text-sm font-bold text-gray-800">{{ $borrower->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm font-mono text-gray-700 bg-gray-100 px-3 py-1 rounded">{{ $borrower->matricule }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $borrower->email }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase
                            @if($borrower->type=='student') bg-blue-100 text-blue-700
                            @elseif($borrower->type=='teacher') bg-purple-100 text-purple-700
                            @else bg-gray-100 text-gray-700 @endif">
                            {{ $borrower->type=='student'?'Étudiant':($borrower->type=='teacher'?'Enseignant':'Personnel') }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('borrowers.edit', $borrower->id) }}" class="w-10 h-10 bg-indigo-500 hover:bg-indigo-600 text-white rounded-xl flex items-center justify-center">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('borrowers.destroy', $borrower->id) }}" method="POST" class="inline" data-confirm="Supprimer cet emprunteur ?">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-10 h-10 bg-rose-500 hover:bg-rose-600 text-white rounded-xl flex items-center justify-center">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-gray-500">Aucun emprunteur trouvé</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(method_exists($borrowers, 'links'))
    <div class="bg-gray-50 px-6 py-4 border-t">{{ $borrowers->links('pagination::tailwind') }}</div>
    @endif
</div>

<div class="mt-8 text-center text-gray-500 text-sm">
    <p><i class="fas fa-code text-indigo-600"></i> Développé par <span class="font-semibold">AZOUTSA ZONSOP OVIANE ARELLE</span> | IAI Cameroun 2026</p>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('form[data-confirm]').forEach(f => {
    f.addEventListener('submit', e => { if(!confirm(f.dataset.confirm)) e.preventDefault(); });
});
</script>
@endpush