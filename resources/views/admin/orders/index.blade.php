<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Persetujuan Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex items-center" role="alert">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm flex items-center" role="alert">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Orders Table Card -->
            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800 uppercase tracking-tight">Antrian Pesanan User</h3>
                    <span class="text-xs font-black px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full uppercase">Persetujuan Diperlukan</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ID Pesanan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pemesan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Detail Material</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-500 font-bold">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $order->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        @foreach($order->items as $item)
                                            <div class="text-sm text-gray-700 flex items-center">
                                                <span class="w-1.5 h-1.5 bg-indigo-400 rounded-full mr-2"></span>
                                                <span class="font-medium">{{ $item->product->name }}</span>
                                                <span class="ml-1 text-xs font-black text-indigo-600">(x{{ $item->quantity }})</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-black rounded-full 
                                        {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $order->status == 'approved' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $order->status == 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                                        {{ strtoupper($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    @if($order->status == 'pending')
                                    <div class="flex justify-end space-x-2">
                                        <form action="{{ route('admin.orders.approve', $order) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-dark px-4 py-2 rounded-lg font-bold text-xs transition-all shadow-sm">
                                                APPROVE
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.orders.reject', $order) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-white hover:bg-red-50 text-red-600 border border-red-200 px-4 py-2 rounded-lg font-bold text-xs transition-all shadow-sm">
                                                REJECT
                                            </button>
                                        </form>
                                    </div>
                                    @else
                                        <span class="text-gray-400 text-xs italic font-medium">Selesai pada {{ $order->updated_at->format('d/m/Y') }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic text-sm">Belum ada pesanan yang perlu diproses.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
