<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Master Material & Stok') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex items-center" role="alert">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Add Material Form -->
                <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center uppercase tracking-wider">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            Registrasi Material Baru
                        </h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.materials.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Kode Material</label>
                                    <input type="text" name="code" class="w-full bg-gray-50 border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg text-sm" required placeholder="Contoh: MAT-001">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Satuan (Unit)</label>
                                    <select name="unit" class="w-full bg-gray-50 border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg text-sm" required>
                                        <option value="lembar">Lembar</option>
                                        <option value="ROL">ROL</option>
                                        <option value="KG">KG</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Nama Material</label>
                                <input type="text" name="name" class="w-full bg-gray-50 border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg text-sm" required placeholder="Contoh: Plat Besi A">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Stok Awal</label>
                                <input type="number" name="stock" class="w-full bg-gray-50 border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg text-sm" required placeholder="0">
                            </div>
                            <div class="pt-2">
                                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg shadow-sm transition-all uppercase text-xs tracking-widest">
                                    Simpan Material Baru
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Add Stock Form (Barang Masuk) -->
                <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center uppercase tracking-wider">
                            <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" /></svg>
                            Update Stok (Barang Masuk)
                        </h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.materials.addStock') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Pilih Material</label>
                                <select name="product_id" class="w-full bg-gray-50 border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg text-sm" required>
                                    <option value="">-- Pilih Material --</option>
                                    @foreach($materials as $material)
                                        <option value="{{ $material->id }}">[{{ $material->code }}] {{ $material->name }} (Saat ini: {{ $material->stock }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Jumlah Masuk</label>
                                <input type="number" name="quantity" min="1" class="w-full bg-gray-50 border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg text-sm" required placeholder="0">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Catatan</label>
                                <input type="text" name="description" class="w-full bg-gray-50 border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg text-sm" placeholder="Contoh: Restok Vendor A">
                            </div>
                            <div class="pt-2">
                                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-lg shadow-sm transition-all uppercase text-xs tracking-widest">
                                    Tambah Stok
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Material Inventory Table -->
            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800 uppercase tracking-tight">Daftar Inventaris Material</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kode</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Material</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Unit</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Stok</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($materials as $material)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-indigo-600 font-bold">{{ $material->code }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $material->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded uppercase">{{ $material->unit }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $material->stock <= 5 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $material->stock }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <form action="{{ route('admin.materials.destroy', $material) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600 transition-colors" onclick="return confirm('Hapus material ini?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Transaction History Card -->
            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800 uppercase tracking-tight font-black">Log Pergerakan Barang Terakhir</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Barang</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Jenis</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Qty</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($transactions as $trx)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">{{ $trx->created_at->format('d/m H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $trx->product->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $trx->type == 'in' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ strtoupper($trx->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-gray-900">{{ $trx->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 italic">{{ $trx->description }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
