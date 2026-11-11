<x-app-layout>
    <div class="p-6 md:p-10 space-y-10">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Overview</h1>
                <p class="text-slate-500 font-medium">Safe flight, {{ Auth::user()->name }}! Here's what's happening today.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 bg-[#066c5f]/10 text-[#066c5f] rounded-full text-sm font-bold border border-[#066c5f]/10 flex items-center gap-2">
                    <span class="w-2 h-2 bg-[#066c5f] rounded-full animate-pulse"></span>
                    Live Dashboard
                </span>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Products Stat -->
            <a href="{{ route('products.edit') }}" class="group relative bg-white p-8 rounded-[2rem] border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-24 h-24 text-[#066c5f]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7.5L12 12M4 7.5l8 4.5m0 0v9M20 7.5v9M4 7.5v9M20 16.5l-8 4.5m-8-4.5l8 4.5" /></svg>
                </div>
                <div class="relative z-10 flex flex-col justify-between h-full">
                    <div class="w-14 h-14 bg-[#066c5f]/10 rounded-2xl flex items-center justify-center text-[#066c5f] mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7.5L12 12M4 7.5l8 4.5m0 0v9M20 7.5v9M4 7.5v9M20 16.5l-8 4.5m-8-4.5l8 4.5" /></svg>
                    </div>
                    <div>
                        <p class="text-4xl font-black text-slate-900 mb-1">{{ $productCount }}</p>
                        <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Total Products</p>
                    </div>
                </div>
            </a>

            <!-- Blog Stat -->
            <a href="{{ route('blog.index') }}" class="group relative bg-white p-8 rounded-[2rem] border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-24 h-24 text-[#F77F1E]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM14 2v4h4" /></svg>
                </div>
                <div class="relative z-10 flex flex-col justify-between h-full">
                    <div class="w-14 h-14 bg-[#F77F1E]/10 rounded-2xl flex items-center justify-center text-[#F77F1E] mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM14 2v4h4" /></svg>
                    </div>
                    <div>
                        <p class="text-4xl font-black text-slate-900 mb-1">{{ $blogCount }}</p>
                        <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Published Posts</p>
                    </div>
                </div>
            </a>

            <!-- Banner Stat -->
            <a href="{{ route('carousels.index') }}" class="group relative bg-white p-8 rounded-[2rem] border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-24 h-24 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <div class="relative z-10 flex flex-col justify-between h-full">
                    <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-600 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <div>
                        <p class="text-4xl font-black text-slate-900 mb-1">{{ $carouselCount }}</p>
                        <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Active Banners</p>
                    </div>
                </div>
            </a>

            <!-- Categories Stat -->
            <a href="{{ route('categories.index') }}" class="group relative bg-white p-8 rounded-[2rem] border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-24 h-24 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                </div>
                <div class="relative z-10 flex flex-col justify-between h-full">
                    <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    </div>
                    <div>
                        <p class="text-4xl font-black text-slate-900 mb-1">{{ $categoryCount }}</p>
                        <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Categories · {{ $typeCount }} Types</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Content Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <!-- History Section -->
            <div class="lg:col-span-2 space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Recent Activity</h2>
                    <div class="flex gap-2">
                        <button class="p-2 bg-[#066c5f]/5 text-[#066c5f] rounded-lg border border-[#066c5f]/10"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg></button>
                    </div>
                </div>

                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-8 border-b border-slate-100 flex flex-wrap gap-4 items-end justify-between">
                        <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap gap-4 items-end">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Filter by Date</label>
                                <input type="date" name="date" value="{{ request('date') }}" 
                                       class="bg-slate-50 border-0 rounded-xl focus:ring-2 focus:ring-[#066c5f] text-sm font-semibold">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Search Activities</label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search description..."
                                       class="w-64 bg-slate-50 border-0 rounded-xl focus:ring-2 focus:ring-[#066c5f] text-sm font-semibold">
                            </div>
                            <button type="submit" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-slate-800 transition-colors">Apply Filters</button>
                        </form>
                    </div>

                    <div class="p-4 overflow-x-auto">
                        @if ($histories->isEmpty())
                            <div class="py-20 text-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <h3 class="text-slate-900 font-black tracking-tight">No data found</h3>
                                <p class="text-slate-500 text-sm mb-6">Try adjusting your filters.</p>
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-[#066c5f] font-bold hover:gap-3 transition-all">Reset Filters <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg></a>
                            </div>
                        @else
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-slate-400 text-xs font-black uppercase tracking-widest">
                                        <th class="px-4 py-4">Time</th>
                                        <th class="px-4 py-4">User</th>
                                        <th class="px-4 py-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($histories as $history)
                                        <tr class="hover:bg-slate-50 transition-colors group">
                                            <td class="px-4 py-5 whitespace-nowrap">
                                                <span class="text-xs font-bold text-slate-400">{{ $history->created_at->timezone('Asia/Jakarta')->format('H:i') }} WIB</span>
                                            </td>
                                            <td class="px-4 py-5">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 font-bold text-xs ring-2 ring-white">
                                                        {{ substr($history->user->name ?? '?', 0, 1) }}
                                                    </div>
                                                    <span class="text-sm font-bold text-slate-900">{{ $history->user->name ?? 'Unknown' }}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-5">
                                                <p class="text-sm text-slate-600 max-w-md truncate group-hover:whitespace-normal transition-all">{{ $history->description }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="p-6">
                                {{ $histories->withQueryString()->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Links / Sidebar info -->
            <div class="space-y-6">
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">System Status</h2>
                
                <div class="bg-gradient-to-br from-[#066c5f] to-[#088a7a] rounded-[2rem] p-8 text-white relative overflow-hidden shadow-xl shadow-[#066c5f]/20">
                    <div class="absolute -right-10 -bottom-10 opacity-10">
                        <svg class="w-64 h-64 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 100-16 8 8 0 000 16zM11 7h2v6h-2V7zm0 8h2v2h-2v-2z" /></svg>
                    </div>
                    <h3 class="text-xl font-black mb-2 italic">Server Status</h3>
                    <div class="flex items-center gap-3 bg-white/20 backdrop-blur-md rounded-xl p-4 mb-6">
                        <span class="w-3 h-3 bg-emerald-400 rounded-full shadow-[0_0_10px_#34d399]"></span>
                        <span class="font-bold">Healthy & Secure</span>
                    </div>
                    <p class="text-emerald-50 text-xs font-bold uppercase tracking-widest mb-2">Last Sync</p>
                    <p class="text-lg font-black">{{ now()->format('d M Y, H:i') }}</p>
                </div>

                <div class="bg-white rounded-[2rem] p-8 border border-slate-200">
                    <h3 class="text-xl font-black mb-6 tracking-tight">Support</h3>
                    <div class="space-y-4">
                        <a href="#" class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-[#066c5f]/5 group-hover:text-[#066c5f] transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-900">Documentation</p>
                                <p class="text-xs text-slate-500 font-medium tracking-tight">Read the guide</p>
                            </div>
                        </a>
                        <a href="https://wa.me/6281335715398" class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-[#F77F1E]/5 group-hover:text-[#F77F1E] transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" /></svg>
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-900">Direct Support</p>
                                <p class="text-xs text-slate-500 font-medium tracking-tight">Chat with tech team</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
