<div>
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="/" wire:navigate class="text-2xl font-bold text-[#2B5AA8]">
                        Helpora
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="/" wire:navigate 
                       class="text-sm font-semibold hover:text-[#2B5AA8] transition-colors {{ request()->is('/') ? 'text-[#2B5AA8]' : 'text-gray-700' }}">
                        Accueil
                    </a>
                    <a href="/services" wire:navigate 
                       class="text-sm font-semibold hover:text-[#2B5AA8] transition-colors {{ request()->is('services') ? 'text-[#2B5AA8]' : 'text-gray-700' }}">
                        Services
                    </a>
                    <a href="/contact" wire:navigate 
                       class="text-sm font-semibold hover:text-[#2B5AA8] transition-colors {{ request()->is('contact') ? 'text-[#2B5AA8]' : 'text-gray-700' }}">
                        Contact
                    </a>

                    <div class="flex items-center gap-3">
                        <a href="/connexion" wire:navigate 
                           class="px-5 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                            Connexion
                        </a>
                        <a href="/inscription" wire:navigate 
                           class="px-5 py-2 text-sm font-semibold bg-[#2B5AA8] text-white rounded-lg hover:bg-[#224A91] transition-colors shadow-sm">
                            Inscription
                        </a>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button @click="$wire.toggleMenu()" type="button" 
                            class="text-gray-700 hover:text-[#2B5AA8] focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        @if($menuOpen)
        <div class="md:hidden border-t border-gray-100">
            <div class="px-4 pt-2 pb-4 space-y-2">
                <a href="/" wire:navigate 
                   class="block px-3 py-2 text-sm font-semibold rounded-lg {{ request()->is('/') ? 'bg-[#E1EAF7] text-[#2B5AA8]' : 'text-gray-700 hover:bg-gray-50' }}">
                    Accueil
                </a>
                <a href="/services" wire:navigate 
                   class="block px-3 py-2 text-sm font-semibold rounded-lg {{ request()->is('services') ? 'bg-[#E1EAF7] text-[#2B5AA8]' : 'text-gray-700 hover:bg-gray-50' }}">
                    Services
                </a>
                <a href="/contact" wire:navigate 
                   class="block px-3 py-2 text-sm font-semibold rounded-lg {{ request()->is('contact') ? 'bg-[#E1EAF7] text-[#2B5AA8]' : 'text-gray-700 hover:bg-gray-50' }}">
                    Contact
                </a>
                <div class="pt-2 space-y-2">
                    <a href="/connexion" wire:navigate 
                       class="block px-3 py-2 text-sm font-semibold text-center text-gray-700 hover:bg-gray-50 rounded-lg">
                        Connexion
                    </a>
                    <a href="/inscription" wire:navigate 
                       class="block px-3 py-2 text-sm font-semibold text-center bg-[#2B5AA8] text-white rounded-lg hover:bg-[#224A91]">
                        Inscription
                    </a>
                </div>
            </div>
        </div>
        @endif
    </nav>
</div>