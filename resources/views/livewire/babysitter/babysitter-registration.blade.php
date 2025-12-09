<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-3xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <!-- En-tête -->
            <div class="mb-8">
                <button wire:click="$emit('closeModal')" class="float-right text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <h2 class="text-2xl font-bold text-gray-900">Inscription Babysitter</h2>
                <p class="text-gray-600 mt-2">Créez votre compte professionnel en quelques étapes</p>
            </div>

            <!-- Stepper -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    @for ($i = 1; $i <= $totalSteps; $i++)
                        <div class="flex items-center {{ $i < $totalSteps ? 'flex-1' : '' }}">
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold
                                    {{ $currentStep >= $i ? 'bg-pink-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                                    {{ $i }}
                                </div>
                                <span class="text-xs mt-2 font-medium {{ $currentStep >= $i ? 'text-pink-600' : 'text-gray-500' }}">
                                    @if($i == 1) Profil
                                    @elseif($i == 2) Contact
                                    @elseif($i == 3) Professionnel
                                    @elseif($i == 4) Compétences
                                    @else Documents
                                    @endif
                                </span>
                            </div>
                            @if ($i < $totalSteps)
                                <div class="flex-1 h-1 mx-4 {{ $currentStep > $i ? 'bg-pink-600' : 'bg-gray-200' }}"></div>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>

            <!-- ÉTAPE 1 - PROFIL -->
            @if ($currentStep == 1)
                <div class="space-y-6">
                    <div class="bg-pink-50 rounded-lg p-4 flex items-center">
                        <div class="bg-pink-600 rounded-full p-3 mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Informations personnelles</h3>
                            <p class="text-sm text-gray-600">Commençons par créer votre profil</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Prénom <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="prenom"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                            @error('prenom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nom <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="nom"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                            @error('nom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" wire:model="email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                            placeholder="votre.email@exemple.com">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Date de naissance <span class="text-red-500">*</span>
                        </label>
                        <input type="date" wire:model="date_naissance"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                        @error('date_naissance') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Mot de passe <span class="text-red-500">*</span>
                            </label>
                            <input type="password" wire:model="mot_de_passe"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                            @error('mot_de_passe') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Confirmer le mot de passe <span class="text-red-500">*</span>
                            </label>
                            <input type="password" wire:model="mot_de_passe_confirmation"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6">
                        <h4 class="font-medium text-gray-900 mb-4">À propos de vous</h4>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="je_fume"
                                    class="w-4 h-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500">
                                <span class="ml-3 text-gray-700">Je fume</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="jai_enfants"
                                    class="w-4 h-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500">
                                <span class="ml-3 text-gray-700">J'ai des enfants</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="permis_conduire"
                                    class="w-4 h-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500">
                                <span class="ml-3 text-gray-700">Je possède un permis de conduire</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="jai_voiture"
                                    class="w-4 h-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500">
                                <span class="ml-3 text-gray-700">J'ai une voiture</span>
                            </label>
                        </div>
                    </div>
                </div>
            @endif

            <!-- ÉTAPE 2 - CONTACT -->
            @if ($currentStep == 2)
                <div class="space-y-6">
                    <div class="bg-pink-50 rounded-lg p-4 flex items-center">
                        <div class="bg-pink-600 rounded-full p-3 mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Contact et localisation</h3>
                            <p class="text-sm text-gray-600">Comment les parents peuvent vous contacter</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Téléphone <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" wire:model="telephone"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                            placeholder="0612345678">
                        @error('telephone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Adresse complète <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" wire:model="adresse"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                placeholder="Rue, Ville">
                            <button type="button"
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 px-4 py-1 bg-pink-600 text-white text-sm rounded-lg hover:bg-pink-700">
                                Auto
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Cliquez sur "Auto" pour utiliser votre localisation actuelle</p>
                        @error('adresse') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Photo de profil</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-pink-400 transition">
                            @if ($photo_profil)
                                <img src="{{ $photo_profil->temporaryUrl() }}" class="mx-auto h-32 w-32 rounded-full object-cover mb-4">
                            @else
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            @endif
                            <label class="cursor-pointer">
                                <span class="text-pink-600 hover:text-pink-700 font-medium">Choisir un fichier</span>
                                <input type="file" wire:model="photo_profil" accept="image/*" class="hidden">
                            </label>
                            <p class="text-xs text-gray-500 mt-2">Format JPG ou PNG, max 5MB</p>
                        </div>
                        <div wire:loading wire:target="photo_profil" class="mt-2 text-sm text-gray-600">
                            Téléchargement en cours...
                        </div>
                    </div>
                </div>
            @endif

            <!-- ÉTAPE 3 - PROFESSIONNEL -->
            @if ($currentStep == 3)
                <div class="space-y-6">
                    <div class="bg-teal-50 rounded-lg p-4 flex items-center">
                        <div class="bg-teal-600 rounded-full p-3 mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Informations professionnelles</h3>
                            <p class="text-sm text-gray-600">Parlez-nous de votre expérience</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Prix horaire (MAD) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" wire:model="prix_horaire" placeholder="Ex: 50"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                            @error('prix_horaire') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Années d'expérience <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="annees_experience"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                                <option value="">Sélectionner...</option>
                                <option value="0-1">Moins d'un an</option>
                                <option value="1-3">1 à 3 ans</option>
                                <option value="3-5">3 à 5 ans</option>
                                <option value="5+">Plus de 5 ans</option>
                            </select>
                            @error('annees_experience') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Niveau d'études <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model="niveau_etudes"
                            placeholder="Ex: Bac+3, Diplôme en petite enfance..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                        @error('niveau_etudes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea wire:model="description" rows="4"
                            placeholder="Parlez de vous, de votre passion pour le babysitting, ce qui vous rend unique..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"></textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Expérience détaillée <span class="text-red-500">*</span>
                        </label>
                        <textarea wire:model="experience_detaillee" rows="5"
                            placeholder="Décrivez votre expérience avec les enfants, âges des enfants, situations spécifiques..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"></textarea>
                        @error('experience_detaillee') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Langues maîtrisées <span class="text-red-500">*</span>
                        </label>
                        <p class="text-sm text-gray-600 mb-3">Sélectionner les langues que vous parlez</p>
                        <div class="flex flex-wrap gap-3">
                            @foreach(['Arabe', 'Français', 'Anglais', 'Espagnol', 'Allemand', 'Italien'] as $langue)
                                <label class="inline-flex items-center px-4 py-2 border-2 rounded-lg cursor-pointer transition
                                    {{ in_array($langue, $langues ?? []) ? 'border-pink-600 bg-pink-50' : 'border-gray-300 hover:border-pink-300' }}">
                                    <input type="checkbox" wire:model="langues" value="{{ $langue }}" class="hidden">
                                    <span class="{{ in_array($langue, $langues ?? []) ? 'text-pink-600 font-medium' : 'text-gray-700' }}">
                                        {{ $langue }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('langues') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Catégories d'enfants
                        </label>
                        <p class="text-sm text-gray-600 mb-3">Avec quelles tranches d'âge êtes-vous familier(e) ?</p>
                        <select wire:model="categories_enfants" multiple
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                            <option value="0-1">0-1 ans (Nourrissons)</option>
                            <option value="1-3">1-3 ans (Tout-petits)</option>
                            <option value="3-6">3-6 ans (Préscolaire)</option>
                            <option value="6-12">6-12 ans (École primaire)</option>
                            <option value="12+">12+ ans (Adolescents)</option>
                        </select>
                    </div>
                </div>
            @endif

            <!-- ÉTAPE 4 - COMPÉTENCES -->
            @if ($currentStep == 4)
                <div class="space-y-6">
                    <div class="bg-purple-50 rounded-lg p-4 flex items-center">
                        <div class="bg-purple-600 rounded-full p-3 mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Compétences et disponibilités</h3>
                            <p class="text-sm text-gray-600">Mettez en valeur vos atouts</p>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-medium text-gray-900 mb-3">Certifications et formations</h4>
                        <p class="text-sm text-gray-600 mb-3">Sélectionnez vos certifications</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach(['Premiers secours', 'PSCI', 'CAP Petite Enfance', 'Brevet d\'aptitude aux fonctions d\'animateur', 'Formation Montessori', 'BCP'] as $cert)
                                <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition
                                    {{ in_array($cert, $certifications ?? []) ? 'border-purple-600 bg-purple-50' : 'border-gray-300 hover:border-purple-300' }}">
                                    <input type="checkbox" wire:model="certifications" value="{{ $cert }}" class="hidden">
                                    <span class="{{ in_array($cert, $certifications ?? []) ? 'text-purple-600 font-medium' : 'text-gray-700' }}">
                                        {{ $cert }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h4 class="font-medium text-gray-900 mb-3">Mes superpouvoirs 🎨</h4>
                        <p class="text-sm text-gray-600 mb-3">Quelles activités aimez-vous faire avec les enfants ?</p>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @php
                                $superpouvoirs = [
                                    ['name' => 'Dessin', 'icon' => '🎨'],
                                    ['name' => 'Travaux manuels', 'icon' => '🔧'],
                                    ['name' => 'Langues', 'icon' => '🌍'],
                                    ['name' => 'Faire la lecture', 'icon' => '📚'],
                                    ['name' => 'Jeux', 'icon' => '🎲'],
                                    ['name' => 'Musique', 'icon' => '🎵'],
                                ];
                            @endphp
                            @foreach($superpouvoirs as $sp)
                                <label class="flex flex-col items-center p-4 border-2 rounded-lg cursor-pointer transition
                                    {{ in_array($sp['name'], $this->superpowers ?? []) ? 'border-purple-600 bg-purple-50' : 'border-gray-300 hover:border-purple-300' }}">
                                    <input type="checkbox" wire:model="superpowers" value="{{ $sp['name'] }}" class="hidden">
                                    <span class="text-3xl mb-2">{{ $sp['icon'] }}</span>
                                    <span class="text-sm {{ in_array($sp['name'], $this->superpowers ?? []) ? 'text-purple-600 font-medium' : 'text-gray-700' }}">
                                        {{ $sp['name'] }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h4 class="font-medium text-gray-900 mb-3">Disponibilités détaillées <span class="text-red-500">*</span></h4>
                        <p class="text-sm text-gray-600 mb-4">Définissez vos plages horaires pour chaque jour (vous pouvez ajouter plusieurs plages par jour)</p>
                        
                        @foreach(['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'] as $jour)
                            <div class="mb-4 p-4 border border-gray-200 rounded-lg">
                                <div class="flex justify-between items-center mb-3">
                                    <h5 class="font-medium text-gray-900 capitalize">{{ $jour }}</h5>
                                    <button type="button" wire:click="ajouterDisponibilite('{{ $jour }}')"
                                        class="px-3 py-1 text-sm bg-pink-600 text-white rounded-lg hover:bg-pink-700">
                                        + Ajouter une plage
                                    </button>
                                </div>
                                
                                @if(empty($disponibilites[$jour]))
                                    <p class="text-sm text-gray-500 italic">Aucune plage horaire définie - Cliquez sur "Ajouter une plage"</p>
                                @else
                                    <div class="space-y-2">
                                        @foreach($disponibilites[$jour] as $index => $plage)
                                            <div class="flex gap-2 items-center">
                                                <input type="time" wire:model="disponibilites.{{ $jour }}.{{ $index }}.debut"
                                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg">
                                                <span class="text-gray-500">à</span>
                                                <input type="time" wire:model="disponibilites.{{ $jour }}.{{ $index }}.fin"
                                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg">
                                                <button type="button" wire:click="supprimerDisponibilite('{{ $jour }}', {{ $index }})"
                                                    class="text-red-600 hover:text-red-800">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- ÉTAPE 5 - DOCUMENTS -->
            @if ($currentStep == 5)
                <div class="space-y-6">
                    <div class="bg-blue-50 rounded-lg p-4 flex items-center">
                        <div class="bg-blue-600 rounded-full p-3 mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Documents médicaux et juridiques</h3>
                            <p class="text-sm text-gray-600">Dernière étape pour finaliser votre profil</p>
                        </div>
                    </div>

                    @php
                        $documents = [
                            ['name' => 'radiographie_thorax', 'label' => 'Radiographie thorax', 'required' => false],
                            ['name' => 'coproculture_selles', 'label' => 'Coproculture des selles', 'required' => false],
                            ['name' => 'certificat_aptitude', 'label' => 'Certificat d\'aptitude mentale', 'required' => false],
                            ['name' => 'casier_judiciaire', 'label' => 'Casier judiciaire (Procédure juridique)', 'required' => true],
                        ];
                    @endphp

                    @foreach($documents as $doc)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $doc['label'] }}
                                @if($doc['required']) <span class="text-red-500">*</span> @endif
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-pink-400 transition">
                                <svg class="mx-auto h-10 w-10 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <label class="cursor-pointer">
                                    <span class="text-pink-600 hover:text-pink-700 font-medium">Choisir un fichier</span>
                                    <input type="file" wire:model="{{ $doc['name'] }}" accept=".pdf,.jpg,.jpeg,.png" class="hidden">
                                </label>
                                <p class="text-xs text-gray-500 mt-2">
                                    @if($this->{$doc['name']})
                                        ✓ Fichier sélectionné
                                    @else
                                        Aucun fichier choisi
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500">PDF, JPG ou PNG</p>
                            </div>
                            <div wire:loading wire:target="{{ $doc['name'] }}" class="mt-2 text-sm text-gray-600">
                                Téléchargement en cours...
                            </div>
                            @error($doc['name']) <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Navigation -->
            <div class="flex justify-between items-center mt-8">
                <button wire:click="precedent" type="button"
                    class="px-6 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition {{ $currentStep == 1 ? 'invisible' : '' }}">
                    Précédent
                </button>

              

                @if ($currentStep < $totalSteps)
                    <button wire:click="suivant" type="button"
                        class="px-6 py-2 text-white bg-pink-600 rounded-lg hover:bg-pink-700 transition">
                        Suivant
                    </button>
                @else
                    <button wire:click="finaliser" type="button"
                        class="px-6 py-2 text-white bg-pink-600 rounded-lg hover:bg-pink-700 transition">
                        Finaliser l'inscription
                    </button>
                @endif
            </div>

            <!-- Messages -->
            @if (session()->has('success'))
                <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mt-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>
</div>