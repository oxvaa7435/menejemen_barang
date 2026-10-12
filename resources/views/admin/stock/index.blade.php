<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Stok (Barang Masuk)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm flex items-center" role="alert">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Input Form Card -->
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Input Barang Masuk
                    </h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.stock.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pilih Produk</label>
                                <select name="product_id" class="w-full bg-gray-50 dark:bg-gray-900 border-transparent focus:border-indigo-500 focus:ring-0 rounded-xl dark:text-white transition-all" required>
                                    <option value="">-- Pilih Material --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">[{{ $product->code }}] {{ $product->name }} (Unit: {{ $product->unit }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Jumlah Unit</label>
                                <input type="number" name="quantity" min="1" class="w-full bg-gray-50 dark:bg-gray-900 border-transparent focus:border-indigo-500 focus:ring-0 rounded-xl dark:text-white transition-all" required placeholder="Contoh: 10">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Keterangan (Opsional)</label>
                                <input type="text" name="description" class="w-full bg-gray-50 dark:bg-gray-900 border-transparent focus:border-indigo-500 focus:ring-0 rounded-xl dark:text-white transition-all" placeholder="Contoh: Restock gudang B">
                            </div>
                        </div>
                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition-all hover:shadow-indigo-500/30">
                                Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Transaction History Card -->
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Riwayat Pergerakan Barang</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Barang</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tipe</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Qty</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($transactions as $trx)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $trx->created_at->format('d M y - H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $trx->product->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 rounded-lg text-xs font-bold {{ $trx->type == 'in' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $trx->type == 'in' ? 'MASUK' : 'KELUAR' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-gray-900 dark:text-gray-100">{{ $trx->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 italic">{{ $trx->description }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
