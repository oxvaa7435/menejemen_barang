<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- 1. Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="bg-indigo-100 p-3 rounded-lg mr-4 text-indigo-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Halo, {{ Auth::user()->name }}!</h3>
                            <p class="text-gray-500 text-sm">Selamat datang di Sistem Manajemen Stok Material.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. My Materials Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 uppercase tracking-tight text-sm text-indigo-600 font-black">Material Saya (Terverifikasi)</h3>
                    <span class="text-[10px] bg-green-100 text-green-700 px-2 py-1 rounded font-bold uppercase">Ready</span>
                </div>
                <div class="p-0 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Kode</th>
                                <th class="px-6 py-3 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Material</th>
                                <th class="px-6 py-3 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Stok</th>
                                <th class="px-6 py-3 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Unit</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($approvedMaterials as $material)
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-6 py-4 text-sm font-mono font-bold text-indigo-500">{{ $material->code }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $material->name }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-xs font-black">{{ $material->total_received }}</span>
                                </td>
                                <td class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase">{{ $material->unit }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic text-sm">Belum ada stok material yang disetujui untuk Anda.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 3. Navigation Buttons -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Catalog -->
                <a href="{{ route('user.products.index') }}" class="block p-6 bg-white rounded-lg border border-gray-200 hover:border-indigo-500 hover:shadow-lg transition-all shadow-sm group">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-indigo-50 p-3 rounded-lg mr-4 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Katalog Material</h4>
                                <p class="text-xs text-gray-500 mt-1">Cari dan pesan barang yang Anda butuhkan.</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-200 group-hover:text-indigo-500 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>

                <!-- Orders -->
                <a href="{{ route('user.orders.index') }}" class="block p-6 bg-white rounded-lg border border-gray-200 hover:border-emerald-500 hover:shadow-lg transition-all shadow-sm group">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-emerald-50 p-3 rounded-lg mr-4 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Status Pesanan</h4>
                                <p class="text-xs text-gray-500 mt-1">Pantau proses persetujuan admin.</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-200 group-hover:text-emerald-500 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
