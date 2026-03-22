{{-- resources/views/borrows/index.blade.php --}}
{{-- Liste des emprunts --}}

@extends('app.master')

@section('title', 'Emprunts - Libra')

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
                <i class="fas fa-exchange-alt mr-3 text-teal-400"></i>Gestion des Emprunts
            </h1>
            <p class="text-indigo-200">Institut Africain d'Informatique</p>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
    <form method="get" action="{{ route('borrows.index') }}" class="flex gap-4">
        <select name="status" class="px-4 py-3 border-2 border-gray-200 rounded-xl">
            <option value="">Tous les statuts</option>
            <option value="active" {{ request('status')=='active'?'selected':'' }}>En cours</option>
            <option value="returned" {{ request('status')=='returned'?'selected':'' }}>Rendu</option>
            <option value="overdue" {{ request('status')=='overdue'?'selected':'' }}>En retard</option>
        </select>
        <select name="borrower_id" class="px-4 py-3 border-2 border-gray-200 rounded-xl">
            <option value="">Tous les emprunteurs</option>
            @foreach($borrowers as $b)
            <option value="{{ $b->id }}" {{ request('borrower_id')==$b->id?'selected':'' }}>{{ $b->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl">
            <i class="fas fa-search"></i>
        </button>
        @if(request('status') || request('borrower_id'))
        <a href="{{ route('borrows.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl">
            <i class="fas fa-times"></i>
        </a>
        @endif
    </form>
</div>

<!-- Tableau des emprunts -->
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <div class="bg-slate-800 px-6 py-4">
        <h2 class="text-xl font-bold text-white"><i class="fas fa-table text-teal-400 mr-2"></i>Historique des Emprunts</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Livre</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Emprunteur</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Date emprunt</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Échéance</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Statut</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($borrows as $borrow)
                <tr class="hover:bg-indigo-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-indigo-100 p-2 rounded-lg"><i class="fas fa-book text-indigo-600"></i></div>
                            <span class="font-bold text-gray-800">{{ $borrow->book->title ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="bg-purple-100 p-2 rounded-lg"><i class="fas fa-user text-purple-600"></i></div>
                            <span class="text-sm text-gray-700">{{ $borrow->borrower->name ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $borrow->borrowed_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-sm {{ $borrow->due_date < now() && $borrow->status != 'returned' ? 'text-rose-600 font-bold' : 'text-gray-600' }}">
                        {{ $borrow->due_date->format('d/m/Y') }}
                        @if($borrow->due_date < now() && $borrow->status != 'returned')<span class="ml-2 text-xs">(Retard)</span>@endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase
                            @if($borrow->status=='active') bg-amber-100 text-amber-700
                            @elseif($borrow->status=='returned') bg-emerald-100 text-emerald-700
                            @else bg-rose-100 text-rose-700 @endif">
                            {{ $borrow->status=='active'?'En cours':($borrow->status=='returned'?'Rendu':'Retard') }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            @if($borrow->status == 'active')
                            <form action="{{ route('borrows.return', $borrow->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="w-10 h-10 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl flex items-center justify-center" title="Marquer comme rendu">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('borrows.destroy', $borrow->id) }}" method="POST" class="inline" data-confirm="Supprimer cet emprunt ?">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-10 h-10 bg-rose-500 hover:bg-rose-600 text-white rounded-xl flex items-center justify-center">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">Aucun emprunt trouvé</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(method_exists($borrows, 'links'))
    <div class="bg-gray-50 px-6 py-4 border-t">{{ $borrows->links('pagination::tailwind') }}</div>
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