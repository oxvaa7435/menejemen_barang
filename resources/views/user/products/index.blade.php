<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Katalog Material') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Alert Section -->
            @if(session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm flex items-center" role="alert">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    <span class="font-bold">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Material Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($products as $product)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                    <!-- Card Header -->
                    <div class="p-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                        <span class="px-2 py-1 bg-white border border-gray-200 rounded text-[10px] font-black text-indigo-600 uppercase tracking-widest">{{ $product->code }}</span>
                        <span class="px-2 py-1 bg-indigo-50 text-indigo-700 text-[10px] font-bold rounded uppercase">{{ $product->unit }}</span>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6">
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-gray-900 leading-tight text-center">{{ $product->name }}</h3>
                        </div>
                        
                        <!-- Stock Info -->
                        <div class="mb-6 bg-slate-50 rounded-xl p-4 flex justify-between items-center border border-gray-50">
                            <div class="text-left">
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Tersedia</p>
                                <p class="text-2xl font-black text-gray-900">{{ $product->stock }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Satuan</p>
                                <p class="text-sm font-bold text-gray-600 uppercase">{{ $product->unit }}</p>
                            </div>
                        </div>

                        <!-- Order Form -->
                        <form action="{{ route('user.products.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 ml-1">Jumlah Pesanan</label>
                                    <div class="relative flex items-center">
                                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-full bg-gray-50 border-gray-200 focus:border-indigo-500 focus:ring-0 rounded-lg text-sm font-bold p-3" required>
                                    </div>
                                </div>
                                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition-all shadow-sm uppercase text-xs tracking-widest flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    Buat Pesanan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            
            @if($products->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 p-12 text-center">
                    <p class="text-gray-500 italic">Belum ada material yang tersedia di katalog.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
