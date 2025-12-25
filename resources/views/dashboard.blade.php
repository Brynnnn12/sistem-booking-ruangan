<x-app-layout>
    <div class="py-4 sm:py-6 lg:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($isAdmin)
                {{-- Admin Dashboard --}}
                <div class="mb-6 grid grid-cols-1 gap-4 sm:mb-8 lg:grid-cols-3 lg:gap-8">
                    <x-ui.stat-card title="Total Ruangan" :value="$totalRooms" color="bg-indigo-500" icon="fas fa-building" />

                    <x-ui.stat-card title="Total Users" :value="$totalUsers" color="bg-green-500" icon="fas fa-users" />

                    <x-ui.stat-card title="Total Booking" :value="$totalBookings" color="bg-yellow-500"
                        icon="fas fa-calendar-check" />
                </div>

                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between sm:gap-4 mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Statistik Booking (7 Hari Terakhir)</h3>
                            <span class="text-xs font-medium uppercase tracking-wider text-gray-400 sm:text-right">Live
                                Report</span>
                        </div>
                        <div class="grid grid-cols-1 gap-4 sm:gap-6 lg:grid-cols-2">
                            <!-- Chart 1: Confirmed Bookings -->
                            <div class="rounded-xl border border-gray-200 p-4 sm:p-5">
                                <h4 class="text-md font-medium text-gray-700 mb-3">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>Booking Dikonfirmasi
                                </h4>
                                <div class="h-64 sm:h-72">
                                    <canvas id="confirmedChart"></canvas>
                                </div>
                            </div>

                            <!-- Chart 2: Pending Bookings -->
                            <div class="rounded-xl border border-gray-200 p-4 sm:p-5">
                                <h4 class="text-md font-medium text-gray-700 mb-3">
                                    <i class="fas fa-clock text-yellow-500 mr-2"></i>Booking Pending
                                </h4>
                                <div class="h-64 sm:h-72">
                                    <canvas id="pendingChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Staff Dashboard --}}
                <div class="mb-8">
                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                        <div class="p-4 sm:p-6">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    Selamat Datang, {{ auth()->user()->name }}
                                </h3>
                                <span
                                    class="inline-flex w-fit items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-800 sm:text-sm">
                                    <i class="fas fa-calendar-check mr-2"></i>
                                    {{ $totalMyBookings }} Total Booking Anda
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                    <div class="p-4 sm:p-6">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900">Riwayat Booking Anda (10 Terakhir)</h3>

                        @if ($userBookings->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 sm:px-6">
                                                Ruangan</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 sm:px-6">
                                                Tanggal</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 sm:px-6">
                                                Waktu</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 sm:px-6">
                                                Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($userBookings as $booking)
                                            <tr>
                                                <td
                                                    class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 sm:px-6 sm:py-4">
                                                    {{ $booking->room->name }}
                                                </td>
                                                <td
                                                    class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 sm:px-6 sm:py-4">
                                                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                                                </td>
                                                <td
                                                    class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 sm:px-6 sm:py-4">
                                                    {{ $booking->start_time }} - {{ $booking->end_time }}
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap sm:px-6 sm:py-4">
                                                    @if ($booking->status === \App\Models\Booking::STATUS_APPROVED)
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Dikonfirmasi
                                                        </span>
                                                    @elseif ($booking->status === \App\Models\Booking::STATUS_PENDING)
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
                                <i class="fas fa-calendar-times mb-4 text-5xl text-gray-300 sm:text-6xl"></i>
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
                        type: 'line',
                        data: {
                            labels: @json($chartLabels),
                            datasets: [{
                                label: 'Booking Dikonfirmasi',
                                data: @json($confirmedData),
                                borderColor: '#059669',
                                backgroundColor: 'rgba(16, 185, 129, 0.15)',
                                tension: 0.35,
                                fill: false,
                                pointRadius: 3,
                                pointHoverRadius: 4,
                                pointBackgroundColor: '#10b981',
                                pointBorderColor: '#059669',
                                borderWidth: 2
                            }]
                        },
                        options: chartOptions
                    });

                    // Chart 2: Pending Bookings
                    new Chart(pendingCanvas.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: @json($chartLabels),
                            datasets: [{
                                label: 'Booking Pending',
                                data: @json($pendingData),
                                borderColor: '#d97706',
                                backgroundColor: 'rgba(245, 158, 11, 0.15)',
                                tension: 0.35,
                                fill: false,
                                pointRadius: 3,
                                pointHoverRadius: 4,
                                pointBackgroundColor: '#f59e0b',
                                pointBorderColor: '#d97706',
                                borderWidth: 2
                            }]
                        },
                        options: chartOptions
                    });
                });
            </script>
        @endpush
    @endif
</x-app-layout>
