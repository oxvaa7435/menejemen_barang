<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Alert Section -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex items-center" role="alert">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Order Table Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 uppercase tracking-tight text-sm">Daftar Pengajuan Pesanan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Order ID</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Detail Material</th>
                                <th class="px-6 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                                <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal Pengajuan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-400 font-bold">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        @foreach($order->items as $item)
                                            <div class="flex items-center">
                                                <div class="w-1.5 h-1.5 bg-indigo-500 rounded-full mr-3"></div>
                                                <span class="text-sm font-bold text-gray-900">{{ $item->product->name }}</span>
                                                <span class="ml-2 text-xs font-black text-indigo-600">x{{ $item->quantity }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-wider
                                        {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $order->status == 'approved' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $order->status == 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-xs text-gray-500 font-bold uppercase">
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic text-sm font-medium">Anda belum memiliki riwayat pengajuan pesanan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
