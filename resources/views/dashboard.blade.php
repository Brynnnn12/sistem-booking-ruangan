<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($isAdmin)
                {{-- Admin Dashboard --}}
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-8 mb-8">
                    <x-ui.stat-card title="Total Ruangan" :value="$totalRooms" color="bg-indigo-500" icon="fas fa-building" />

                    <x-ui.stat-card title="Total Users" :value="$totalUsers" color="bg-green-500" icon="fas fa-users" />

                    <x-ui.stat-card title="Total Booking" :value="$totalBookings" color="bg-yellow-500"
                        icon="fas fa-calendar-check" />
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Statistik Booking (7 Hari Terakhir)</h3>
                            <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Live Report</span>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Chart 1: Confirmed Bookings -->
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="text-md font-medium text-gray-700 mb-3">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>Booking Dikonfirmasi
                                </h4>
                                <div style="height: 300px;">
                                    <canvas id="confirmedChart"></canvas>
                                </div>
                            </div>

                            <!-- Chart 2: Pending Bookings -->
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="text-md font-medium text-gray-700 mb-3">
                                    <i class="fas fa-clock text-yellow-500 mr-2"></i>Booking Pending
                                </h4>
                                <div style="height: 300px;">
                                    <canvas id="pendingChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Staff Dashboard --}}
                <div class="mb-8">
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Selamat Datang,
                                    {{ auth()->user()->name }}</h3>
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-calendar-check mr-2"></i>
                                    {{ $totalMyBookings }} Total Booking Anda
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Booking Anda (10 Terakhir)</h3>

                        @if ($userBookings->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Ruangan</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tanggal</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Waktu</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($userBookings as $booking)
                                            <tr>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $booking->room->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $booking->start_time }} - {{ $booking->end_time }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if ($booking->status === 'confirmed')
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Dikonfirmasi
                                                        </span>
                                                    @elseif ($booking->status === 'pending')
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            Pending
                                                        </span>
                                                    @else
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Dibatalkan
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <i class="fas fa-calendar-times text-gray-300 text-6xl mb-4"></i>
                                <p class="text-gray-500">Anda belum memiliki booking</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if ($isAdmin)
        @push('scripts')
            {{-- Kita berasumsi Chart.js sudah di-import di app.js via Vite --}}
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const confirmedCanvas = document.getElementById('confirmedChart');
                    const pendingCanvas = document.getElementById('pendingChart');

                    if (!confirmedCanvas || !pendingCanvas) return;

                    const chartOptions = {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#f3f4f6'
                                },
                                ticks: {
                                    stepSize: 1
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    };

                    // Chart 1: Confirmed Bookings
                    new Chart(confirmedCanvas.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: @json($chartLabels),
                            datasets: [{
                                label: 'Booking Dikonfirmasi',
                                data: @json($confirmedData),
                                backgroundColor: '#10b981',
                                borderColor: '#059669',
                                borderWidth: 1,
                                borderRadius: 4,
                                hoverBackgroundColor: '#059669'
                            }]
                        },
                        options: chartOptions
                    });

                    // Chart 2: Pending Bookings
                    new Chart(pendingCanvas.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: @json($chartLabels),
                            datasets: [{
                                label: 'Booking Pending',
                                data: @json($pendingData),
                                backgroundColor: '#f59e0b',
                                borderColor: '#d97706',
                                borderWidth: 1,
                                borderRadius: 4,
                                hoverBackgroundColor: '#d97706'
                            }]
                        },
                        options: chartOptions
                    });
                });
            </script>
        @endpush
    @endif
</x-app-layout>
