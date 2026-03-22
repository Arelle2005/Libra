{{-- resources/views/borrows/index.blade.php --}}
{{-- Liste des emprunts avec filtrage --}}

@extends('app.master')

@section('title', 'Gestion des Emprunts - Libra')

@section('content')
<!-- En-tête avec Logo IAI -->
<div class="mb-8 bg-gradient-to-r from-indigo-900 via-purple-900 to-slate-900 rounded-2xl shadow-xl p-8 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
    
    <div class="relative z-10 flex items-center justify-between">
        <div class="flex items-center gap-6">
            <div class="bg-white rounded-xl p-3 shadow-lg">
                <img src="{{ asset('images/logoiai.webp') }}"
                     alt="IAI Cameroun" 
                     class="h-16 w-auto object-contain">
            </div>
            <div>
                <h1 class="text-4xl font-bold text-white mb-2 tracking-tight">
                    <i class="fas fa-exchange-alt mr-3 text-teal-400"></i>Gestion des Emprunts
                </h1>
                <p class="text-indigo-200 text-lg">Institut Africain d'Informatique - Centre d'Excellence Technologique Paul Biya</p>
                <p class="text-indigo-300 text-sm mt-1">
                    <i class="fas fa-layer-group mr-2"></i>{{ $borrows->total() ?? 0 }} emprunt(s) enregistré(s)
                </p>
            </div>
        </div>
        <div class="hidden lg:block">
            <a href="{{ route('borrows.create') }}" class="group inline-flex items-center gap-2 bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-plus-circle text-xl group-hover:rotate-90 transition-transform"></i>
                <span>Nouvel emprunt</span>
            </a>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="bg-gradient-to-r from-white to-gray-50 rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
    <form method="get" action="{{ route('borrows.index') }}" class="flex flex-col md:flex-row gap-4">
        <select name="status" class="px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-indigo-500">
            <option value="">Tous les statuts</option>
            <option value="active" {{ request('status')=='active'?'selected':'' }}>En cours</option>
            <option value="returned" {{ request('status')=='returned'?'selected':'' }}>Rendu</option>
            <option value="overdue" {{ request('status')=='overdue'?'selected':'' }}>En retard</option>
        </select>
        <select name="borrower_id" class="px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-indigo-500">
            <option value="">Tous les emprunteurs</option>
            @foreach($borrowers as $b)
            <option value="{{ $b->id }}" {{ request('borrower_id')==$b->id?'selected':'' }}>{{ $b->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold px-8 py-3 rounded-xl shadow-md">
            <i class="fas fa-search"></i> Filtrer
        </button>
        @if(request('status') || request('borrower_id'))
        <a href="{{ route('borrows.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-8 py-3 rounded-xl">
            <i class="fas fa-times"></i> Effacer
        </a>
        @endif
    </form>
</div>

<!-- Tableau des emprunts -->
<div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
    <div class="bg-gradient-to-r from-slate-800 to-slate-900 px-6 py-4">
        <h2 class="text-xl font-bold text-white"><i class="fas fa-table text-teal-400 mr-2"></i>Historique des Emprunts</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-indigo-100">
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase"><i class="fas fa-book mr-2 text-indigo-500"></i>Livre</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase"><i class="fas fa-user mr-2 text-purple-500"></i>Emprunteur</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase"><i class="fas fa-calendar mr-2 text-teal-500"></i>Date emprunt</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase"><i class="fas fa-clock mr-2 text-orange-500"></i>Échéance</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase"><i class="fas fa-info-circle mr-2 text-rose-500"></i>Statut</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase"><i class="fas fa-cog mr-2 text-gray-500"></i>Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($borrows as $borrow)
                <tr class="group hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition-all">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-indigo-100 p-2 rounded-lg"><i class="fas fa-book text-indigo-600"></i></div>
                            <span class="text-sm font-bold text-gray-800">{{ $borrow->book->title ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="bg-purple-100 p-2 rounded-lg"><i class="fas fa-user text-purple-600"></i></div>
                            <span class="text-sm text-gray-700">{{ $borrow->borrower->name ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $borrow->borrowed_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-sm {{ $borrow->isOverdue() ? 'text-rose-600 font-bold' : 'text-gray-600' }}">
                        {{ $borrow->due_date->format('d/m/Y') }}
                        @if($borrow->isOverdue())<span class="ml-2 text-xs">(Retard)</span>@endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase
                            @if($borrow->status=='active') bg-amber-100 text-amber-700
                            @elseif($borrow->status=='returned') bg-emerald-100 text-emerald-700
                            @else bg-rose-100 text-rose-700 @endif">
                            {{ $borrow->status=='active'?'En cours':($borrow->status=='returned'?'Rendu':'Retard') }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
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