<div class="py-6 bg-gray-50 min-h-screen font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- En-tête -->
        <div class="mb-5">
            <h1 class="text-2xl font-bold text-gray-900">Mes demandes</h1>
            <p class="text-sm text-gray-500 mt-1">Gérez toutes vos demandes de services</p>
        </div>

        <!-- CARTES STATISTIQUES -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-5">
            <!-- Total -->
            <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Total</p>
                    <p class="text-xl font-bold text-gray-900 mt-0.5">{{ $stats['total'] }}</p>
                </div>
                <div class="w-9 h-9 bg-blue-50 rounded-full flex items-center justify-center text-blue-600">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <!-- Acceptées -->
            <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Acceptées</p>
                    <p class="text-xl font-bold text-gray-900 mt-0.5">{{ $stats['acceptees'] }}</p>
                </div>
                <div class="w-9 h-9 bg-green-50 rounded-full flex items-center justify-center text-green-600">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <!-- En attente -->
            <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">En attente</p>
                    <p class="text-xl font-bold text-gray-900 mt-0.5">{{ $stats['attente'] }}</p>
                </div>
                <div class="w-9 h-9 bg-amber-50 rounded-full flex items-center justify-center text-amber-600">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <!-- Refusées -->
            <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Refusées</p>
                    <p class="text-xl font-bold text-gray-900 mt-0.5">{{ $stats['refusees'] }}</p>
                </div>
                <div class="w-9 h-9 bg-red-50 rounded-full flex items-center justify-center text-red-600">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- SECTION FILTRES -->
        <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-100 mb-5">
            <div class="flex flex-col lg:flex-row gap-3 items-center">
                
                <!-- LABEL FILTRES -->
                <div class="flex items-center gap-2 text-gray-900 font-bold text-sm min-w-max">
                    <svg class="w-4.5 h-4.5 text-blue-900" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 4.6C3 4.03995 3 3.75992 3.10899 3.54601C3.20487 3.35785 3.35785 3.20487 3.54601 3.10899C3.75992 3 4.03995 3 4.6 3H19.4C19.9601 3 20.2401 3 20.454 3.10899C20.6422 3.20487 20.7951 3.35785 20.891 3.54601C21 3.75992 21 4.03995 21 4.6V6.33726C21 6.58185 21 6.70414 20.9724 6.81923C20.9479 6.92127 20.9075 7.01881 20.8526 7.10828C20.7908 7.2092 20.7043 7.29568 20.5314 7.46863L14.4686 13.5314C14.2957 13.7043 14.2092 13.7908 14.1474 13.8917C14.0925 13.9812 14.0521 14.0787 14.0276 14.1808C14 14.2959 14 14.4182 14 14.6627V20L10 21V14.6627C10 14.4182 10 14.2959 9.97237 14.1808C9.94787 14.0787 9.90747 13.9812 9.85264 13.8917C9.7908 13.7908 9.70432 13.7043 9.53137 13.5314L3.46863 7.46863C3.29568 7.29568 3.2092 7.2092 3.14736 7.10828C3.09253 7.01881 3.05213 6.92127 3.02763 6.81923C3 6.70414 3 6.58185 3 6.33726V4.6Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Filtres</span>
                </div>

                <!-- BARRE DE RECHERCHE -->
                <div class="relative w-full lg:w-1/3">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input wire:model.live="search" type="text" 
                           class="w-full pl-9 pr-3 py-2 text-xs bg-gray-50 border border-gray-200 focus:bg-white focus:border-blue-500 rounded-full text-gray-600 transition outline-none shadow-sm" 
                           placeholder="Rechercher...">
                </div>
                
                <!-- DROPDOWN SERVICES -->
                <div x-data="{ open: false }" class="relative w-full lg:w-1/3">
                    <button @click="open = !open" @click.away="open = false" type="button" 
                            class="w-full py-2 px-3.5 text-xs bg-white border-2 border-blue-800 text-gray-800 rounded-full font-medium flex justify-between items-center shadow-sm hover:bg-gray-50 transition">
                        <span class="truncate">
                            @if($filtreService == 1) Soutien scolaire
                            @elseif($filtreService == 2) Babysitting
                            @elseif($filtreService == 3) Garde d'animaux
                            @else Tous les services
                            @endif
                        </span>
                        <svg class="w-3.5 h-3.5 text-gray-800 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="open" style="display: none;" class="absolute z-50 w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-xl overflow-hidden">
                        <div class="bg-gray-600 text-white px-3 py-2 text-xs font-bold">Tous les services</div>
                        <div class="max-h-40 overflow-y-auto">
                            <div wire:click="$set('filtreService', '')" @click="open = false" 
                                 class="px-3 py-2 text-xs text-gray-700 hover:bg-gray-100 cursor-pointer border-b border-gray-100 transition-colors">
                                Afficher tout
                            </div>
                            <div wire:click="$set('filtreService', 1)" @click="open = false" 
                                 class="px-3 py-2 text-xs text-gray-700 hover:bg-gray-200 cursor-pointer transition-colors flex justify-between items-center">
                                <span>Soutien scolaire</span>
                                @if($filtreService == 1)
                                    <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                @endif
                            </div>
                            <div wire:click="$set('filtreService', 2)" @click="open = false" 
                                 class="px-3 py-2 text-xs text-gray-700 hover:bg-gray-200 cursor-pointer transition-colors flex justify-between items-center">
                                <span>Babysitting</span>
                                @if($filtreService == 2)
                                    <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                @endif
                            </div>
                            <div wire:click="$set('filtreService', 3)" @click="open = false" 
                                 class="px-3 py-2 text-xs text-gray-700 hover:bg-gray-200 cursor-pointer transition-colors flex justify-between items-center">
                                <span>Garde d'animaux</span>
                                @if($filtreService == 3)
                                    <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- DROPDOWN STATUTS -->
                <div x-data="{ open: false }" class="relative w-full lg:w-1/3">
                    <button @click="open = !open" @click.away="open = false" type="button" 
                            class="w-full py-2 px-3.5 text-xs bg-gray-50 border border-gray-200 text-gray-700 rounded-full font-medium flex justify-between items-center hover:bg-gray-100 transition shadow-sm">
                        <span>
                            @if($filtreStatut == 'en_attente') En attente
                            @elseif($filtreStatut == 'validée') Acceptées
                            @elseif($filtreStatut == 'refusée') Refusées
                            @else Tous les statuts
                            @endif
                        </span>
                        <svg class="w-3.5 h-3.5 text-gray-500 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="open" style="display: none;" class="absolute z-40 w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden">
                        <div wire:click="$set('filtreStatut', '')" @click="open = false" class="px-3.5 py-2 text-xs text-gray-700 hover:bg-gray-100 cursor-pointer border-b border-gray-50">
                            Tous les statuts
                        </div>
                        <div wire:click="$set('filtreStatut', 'en_attente')" @click="open = false" class="px-3.5 py-2 text-xs text-amber-600 hover:bg-amber-50 cursor-pointer">
                            En attente
                        </div>
                        <div wire:click="$set('filtreStatut', 'validée')" @click="open = false" class="px-3.5 py-2 text-xs text-green-600 hover:bg-green-50 cursor-pointer">
                            Acceptées
                        </div>
                        <div wire:click="$set('filtreStatut', 'refusée')" @click="open = false" class="px-3.5 py-2 text-xs text-red-600 hover:bg-red-50 cursor-pointer">
                            Refusées
                        </div>
                        <div wire:click="$set('filtreStatut', 'annulée')" @click="open = false" class="px-3.5 py-2 text-xs text-gray-500 hover:bg-gray-100 cursor-pointer border-t border-gray-50">
                            Annulées
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- LISTE DES DEMANDES -->
        <div class="space-y-3">
            @if($demandes->count() === 0)
                <div class="bg-white p-8 rounded-xl shadow text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-base font-medium">Aucune demande trouvée</p>
                    <p class="text-xs mt-1">Essayez de modifier vos filtres de recherche</p>
                </div>
            @endif

            @foreach($demandes as $demande)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3.5 flex flex-col md:flex-row justify-between items-start md:items-center gap-3 hover:shadow-md transition-shadow duration-200">
                    
                    <!-- LEFT SECTION -->
                    <div class="space-y-2 flex-1 min-w-0">
                        <div class="flex items-start justify-between">
                            <h3 class="text-sm font-bold text-gray-900 truncate flex-1">
                                {{ $demande->nomService }}
                            </h3>
                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold shrink-0
                                @if($demande->statut === 'validée') bg-green-100 text-green-700
                                @elseif($demande->statut === 'en_attente') bg-amber-100 text-amber-700
                                @elseif($demande->statut === 'refusée') bg-red-100 text-red-700
                                @elseif($demande->statut === 'annulée') bg-gray-100 text-gray-700
                                @else bg-red-100 text-red-700
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $demande->statut)) }}
                            </span>
                        </div>

                        <!-- Time slots -->
                        @if($demande->note_speciales)
                            <p class="text-xs text-gray-600 line-clamp-2">{{ $demande->note_speciales }}</p>
                        @endif

                        <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ \Carbon\Carbon::parse($demande->dateSouhaitee)->format('d M Y') }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ substr($demande->heureDebut,0,5) }} - {{ substr($demande->heureFin,0,5) }}
                            </span>
                        </div>
                    </div>

                    <!-- RIGHT SECTION -->
                    <div class="text-right space-y-1.5 min-w-[160px]">
                        <div>
                            <p class="text-xs text-gray-500">Prix estimé</p>
                            <p class="text-2xl font-extrabold text-gray-900">
                                {{ $demande->prix_estime ?? 0 }} MAD
                            </p>
                        </div>

                        <div class="flex gap-2 justify-end">
                            <button wire:click="openModal({{ $demande->idDemande }})"
                                    class="px-3 py-1.5 bg-blue-600 text-white rounded-full text-xs font-medium hover:bg-blue-700 transition-colors duration-200 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Détails
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

            @if($demandes->hasPages())
                <div class="mt-6">{{ $demandes->links() }}</div>
            @endif
        </div>

    </div>
</div>