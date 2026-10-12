<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Welcome Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-b border-gray-200">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}!</h1>
                    <p class="text-gray-600">Sistem Manajemen Inventaris & Pesanan Material.</p>
                </div>
            </div>

            <!-- Metrics Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Pending Orders -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center border border-gray-200">
                    <div class="flex-shrink-0 p-4 bg-yellow-100 rounded-lg">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate uppercase tracking-wider">Pesanan Baru</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-bold text-gray-900">{{ $ordersCount->firstWhere('status', 'pending')->count ?? 0 }}</div>
                                <div class="ml-2 flex items-baseline text-sm font-semibold text-yellow-600">Menunggu</div>
                            </dd>
                        </dl>
                    </div>
                </div>

                <!-- Approved Orders -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center border border-gray-200">
                    <div class="flex-shrink-0 p-4 bg-green-100 rounded-lg">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate uppercase tracking-wider">Total Selesai</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-bold text-gray-900">{{ $ordersCount->firstWhere('status', 'approved')->count ?? 0 }}</div>
                                <div class="ml-2 flex items-baseline text-sm font-semibold text-green-600">Berhasil</div>
                            </dd>
                        </dl>
                    </div>
                </div>

                <!-- Low Stock -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center border border-gray-200">
                    <div class="flex-shrink-0 p-4 bg-red-100 rounded-lg">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate uppercase tracking-wider">Stok Kritis</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-bold text-gray-900">{{ $latestStock->where('stock', '<=', 5)->count() }}</div>
                                <div class="ml-2 flex items-baseline text-sm font-semibold text-red-600">Item</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Charts and Table Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Stock Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Visualisasi Stok Terkini</h3>
                        <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold rounded">BAR CHART</span>
                    </div>
                    <div class="h-64">
                        <canvas id="stockChart"></canvas>
                    </div>
                </div>

                <!-- Best Requests Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Material Paling Diminati</h3>
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded">DOUGHNUT</span>
                    </div>
                    <div class="h-64">
                        <canvas id="bestSellingChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Latest Stock Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">Monitor Stok Produk</h3>
                    <a href="{{ route('admin.materials.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-900 transition-colors">Lihat Semua &rarr;</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kode</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Material</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Stok</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Satuan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($latestStock as $product)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-indigo-600">{{ $product->code }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">{{ $product->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $product->stock <= 5 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500 font-bold uppercase">
                                    {{ $product->unit }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Use standard colors and simple configuration to avoid rendering issues
        const ctxStock = document.getElementById('stockChart').getContext('2d');
        new Chart(ctxStock, {
            type: 'bar',
            data: {
                labels: {!! json_encode($latestStock->pluck('name')) !!},
                datasets: [{
                    label: 'Jumlah Stok',
                    data: {!! json_encode($latestStock->pluck('stock')) !!},
                    backgroundColor: '#4f46e5',
                    borderColor: '#4338ca',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        const ctxBest = document.getElementById('bestSellingChart').getContext('2d');
        new Chart(ctxBest, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($bestSelling->pluck('name')) !!},
                datasets: [{
                    data: {!! json_encode($bestSelling->pluck('total_sold')) !!},
                    backgroundColor: ['#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
