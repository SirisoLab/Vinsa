<aside 
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    class="fixed lg:sticky top-0 left-0 z-40 w-72 h-screen transition-transform duration-300 ease-in-out bg-slate-900 border-r border-slate-800 text-slate-300 flex flex-col shadow-2xl">
    
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }
    </style>
    
    <!-- Sidebar Header -->
    <div class="h-20 flex items-center px-8 border-b border-slate-800">
        <div class="flex items-center gap-3">
            <img src="/image/vinsalg.png" alt="Vinsa Logo" class="h-10 w-auto">
        </div>
        <button @click="sidebarOpen = false" class="ml-auto p-2 rounded-lg hover:bg-slate-800 lg:hidden">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>

    <!-- Navigation Area -->
    <div class="flex-1 overflow-y-auto py-6 px-4 space-y-8 custom-scrollbar">
        
        <!-- Main Section -->
        <div>
            <h3 class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">Core</h3>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-[#066c5f] text-white shadow-lg shadow-[#066c5f]/20' : 'hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    <span class="font-medium">{{ __('Dashboard') }}</span>
                </a>
            </div>
        </div>

        <!-- Catalog Section -->
        <div x-data="{ open: {{ (request()->routeIs('products.*') || request()->routeIs('categories.*') || request()->routeIs('types.*') ? 'true' : 'false') }} }">
            <h3 class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">{{ __('Catalog Management') }}</h3>
            <div class="space-y-1">
                <a href="{{ route('categories.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('categories.*') ? 'bg-[#066c5f] text-white shadow-lg shadow-[#066c5f]/20' : 'hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    <span class="font-medium">{{ __('Master Categories') }}</span>
                </a>

                <a href="{{ route('types.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('types.*') ? 'bg-[#066c5f] text-white shadow-lg shadow-[#066c5f]/20' : 'hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                    <span class="font-medium">{{ __('Master Types') }}</span>
                </a>

                <button @click="open = !open" 
                   class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 hover:bg-slate-800 hover:text-white">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7.5L12 12M4 7.5l8 4.5m0 0v9M20 7.5v9M4 7.5v9M20 16.5l-8 4.5m-8-4.5l8 4.5" /></svg>
                        <span class="font-medium">Products</span>
                    </div>
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="open" x-collapse class="pl-12 space-y-1">
                    <a href="{{ route('products.view') }}" class="block py-2 text-sm transition-colors {{ request()->routeIs('products.view') ? 'text-[#F77F1E]' : 'hover:text-white' }}">{{ __('Tambah Produk') }}</a>
                    <a href="{{ route('products.edit') }}" class="block py-2 text-sm transition-colors {{ request()->routeIs('products.edit') || request()->routeIs('products.editss') ? 'text-[#F77F1E]' : 'hover:text-white' }}">{{ __('Perbarui Produk') }}</a>
                    <a href="{{ route('products.import.view') }}" class="block py-2 text-sm transition-colors {{ request()->routeIs('products.import.view') ? 'text-[#F77F1E]' : 'hover:text-white' }}">{{ __('Mass Upload / Update') }}</a>
                </div>

            </div>
        </div>

        <!-- Marketing Section -->
        <div x-data="{ open: {{ (request()->routeIs('carousels.*') ? 'true' : 'false') }} }">
            <h3 class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">{{ __('Marketing') }}</h3>
            <div class="space-y-1">
                <button @click="open = !open" 
                   class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 hover:bg-slate-800 hover:text-white">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <span class="font-medium">Banners</span>
                    </div>
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="open" x-collapse class="pl-12 space-y-1">
                    <a href="{{ route('carousels.create') }}" class="block py-2 text-sm transition-colors {{ request()->routeIs('carousels.create') ? 'text-[#F77F1E]' : 'hover:text-white' }}">{{ __('Tambah Banner') }}</a>
                    <a href="{{ route('carousels.index') }}" class="block py-2 text-sm transition-colors {{ request()->routeIs('carousels.index') ? 'text-[#F77F1E]' : 'hover:text-white' }}">{{ __('Perbarui Banner') }}</a>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div x-data="{ open: {{ (request()->routeIs('blog.*') ? 'true' : 'false') }} }">
            <h3 class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">{{ __('Content') }}</h3>
            <div class="space-y-1">
                <button @click="open = !open" 
                   class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 hover:bg-slate-800 hover:text-white">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM14 2v4h4" /></svg>
                        <span class="font-medium">Blog</span>
                    </div>
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="open" x-collapse class="pl-12 space-y-1">
                    <a href="{{ route('blog.create') }}" class="block py-2 text-sm transition-colors {{ request()->routeIs('blog.create') ? 'text-[#F77F1E]' : 'hover:text-white' }}">{{ __('Tambah Blog') }}</a>
                    <a href="{{ route('blog.index') }}" class="block py-2 text-sm transition-colors {{ request()->routeIs('blog.index') ? 'text-[#F77F1E]' : 'hover:text-white' }}">{{ __('Perbarui Blog') }}</a>
                </div>
            </div>
        </div>

    </div>

    <!-- Sidebar Footer (User) -->
    <div class="p-4 border-t border-slate-800">
        <div class="flex items-center gap-3 p-3 rounded-2xl bg-slate-800/50">
            <div class="w-10 h-10 rounded-full bg-[#066c5f] flex items-center justify-center text-white font-bold ring-2 ring-[#066c5f]/20">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
            </div>
            
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="p-2 hover:bg-slate-700 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" /></svg>
                </button>
                
                <div x-show="open" @click.away="open = false" 
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="absolute bottom-full right-0 mb-2 w-48 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl py-2 z-50">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-slate-700 text-slate-300 hover:text-white">{{ __('Profile') }}</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-rose-500/10 text-rose-400 hover:text-rose-500 transition-colors">{{ __('Log Out') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- Mobile Overlay -->
<div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-slate-900/50 backdrop-blur-sm lg:hidden"></div>
