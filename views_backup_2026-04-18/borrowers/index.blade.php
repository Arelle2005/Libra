{{-- resources/views/borrowers/index.blade.php --}}
{{-- Liste des emprunteurs --}}

@extends('app.master')

@section('title', 'Emprunteurs - Libra')

@section('content')
<!-- En-tête -->
<div class="mb-8 bg-gradient-to-r from-indigo-900 via-purple-900 to-slate-900 rounded-2xl shadow-xl p-8">
    <div class="flex items-center gap-6">
        <div class="bg-white rounded-xl p-3 shadow-lg">
            <img src="{{ asset('images/logoiai.webp') }}"
                 alt="IAI Cameroun" 
                 class="h-16 w-auto object-contain">
        </div>
        <div>
            <h1 class="text-4xl font-bold text-white mb-2">
                <i class="fas fa-users mr-3 text-teal-400"></i>Emprunteurs
            </h1>
            <p class="text-indigo-200">Institut Africain d'Informatique</p>
        </div>
    </div>
</div>

<!-- Barre de recherche -->
<div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
    <form method="get" action="{{ route('borrowers.index') }}" class="flex gap-4">
        <input type="text" name="q" value="{{ request('q') }}" 
               placeholder="Rechercher par nom, matricule ou email..." 
               class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500">
        <select name="type" class="px-4 py-3 border-2 border-gray-200 rounded-xl">
            <option value="">Tous les types</option>
            <option value="student" {{ request('type')=='student'?'selected':'' }}>Étudiants</option>
            <option value="teacher" {{ request('type')=='teacher'?'selected':'' }}>Enseignants</option>
            <option value="staff" {{ request('type')=='staff'?'selected':'' }}>Personnel</option>
        </select>
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl">
            <i class="fas fa-search"></i>
        </button>
        @if(request('q') || request('type'))
        <a href="{{ route('borrowers.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl">
            <i class="fas fa-times"></i>
        </a>
        @endif
    </form>
</div>

<!-- Liste des emprunteurs -->
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <div class="bg-slate-800 px-6 py-4">
        <h2 class="text-xl font-bold text-white"><i class="fas fa-table text-teal-400 mr-2"></i>Liste des Emprunteurs</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Nom</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Matricule</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Type</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($borrowers as $borrower)
                <tr class="hover:bg-indigo-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-indigo-100 p-2 rounded-lg"><i class="fas fa-user text-indigo-600"></i></div>
                            <span class="font-bold text-gray-800">{{ $borrower->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm font-mono">{{ $borrower->matricule }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $borrower->email }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase
                            @if($borrower->type=='student') bg-blue-100 text-blue-700
                            @elseif($borrower->type=='teacher') bg-purple-100 text-purple-700
                            @else bg-gray-100 text-gray-700 @endif">
                            {{ $borrower->type=='student'?'Étudiant':($borrower->type=='teacher'?'Enseignant':'Personnel') }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('borrowers.edit', $borrower->id) }}" class="w-10 h-10 bg-indigo-500 hover:bg-indigo-600 text-white rounded-xl flex items-center justify-center">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('borrowers.destroy', $borrower->id) }}" method="POST" class="inline" data-confirm="Supprimer ?">
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