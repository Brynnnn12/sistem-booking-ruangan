<div x-show="isSidebarOpen" @click.away="isSidebarOpen = false" class="fixed inset-0 z-50 md:hidden" x-cloak>
    <div class="fixed inset-0 bg-gray-800 bg-opacity-75" @click="isSidebarOpen = false"></div>

    <div class="fixed inset-y-0 left-0 w-72 max-w-[85vw] bg-blue-800 text-white shadow-xl">
        <div class="flex h-full flex-col p-4">
            <div class="mb-4 mt-1 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-chart-line text-blue-200"></i>
                    <span class="text-base font-semibold text-white">Dashboard</span>
                </div>
                <button type="button" class="rounded-lg p-2 text-blue-100 hover:bg-blue-700"
                    @click="isSidebarOpen = false" aria-label="Tutup">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <nav class="flex-1 space-y-6">
                <div>
                    <p class="mb-2 px-2 text-xs font-semibold uppercase tracking-wider text-blue-200/90">Dashboard</p>
                    <a href="{{ route('dashboard.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition hover:bg-blue-700 {{ request()->routeIs('dashboard.index') ? 'bg-blue-700 text-white' : 'text-blue-100' }}"
                        @click="isSidebarOpen = false">
                        <i class="fas fa-home text-blue-200"></i>
                        <span>Ringkasan</span>
                    </a>
                </div>

                @hasrole('Admin')
                    <div>
                        <p class="mb-2 px-2 text-xs font-semibold uppercase tracking-wider text-blue-200/90">Manajemen</p>
                        <a href="{{ route('dashboard.rooms.index') }}"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition hover:bg-blue-700 {{ request()->routeIs('dashboard.rooms.*') ? 'bg-blue-700 text-white' : 'text-blue-100' }}"
                            @click="isSidebarOpen = false">
                            <i class="fas fa-building text-blue-200"></i>
                            <span>Ruangan</span>
                        </a>

                        <a href="{{ route('dashboard.employees.index') }}"
                            class="mt-1 flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition hover:bg-blue-700 {{ request()->routeIs('dashboard.employees.*') ? 'bg-blue-700 text-white' : 'text-blue-100' }}"
                            @click="isSidebarOpen = false">
                            <i class="fas fa-users text-blue-200"></i>
                            <span>Pegawai</span>
                        </a>

                        <a href="{{ route('dashboard.bookings.index') }}"
                            class="mt-1 flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition hover:bg-blue-700 {{ request()->routeIs('dashboard.bookings.*') ? 'bg-blue-700 text-white' : 'text-blue-100' }}"
                            @click="isSidebarOpen = false">
                            <i class="fas fa-calendar text-blue-200"></i>
                            <span>Semua Booking</span>
                        </a>
                    </div>
                @endhasrole

                @hasrole('Staff')
                    <div>
                        <p class="mb-2 px-2 text-xs font-semibold uppercase tracking-wider text-blue-200/90">Booking</p>
                        <a href="{{ route('dashboard.bookings.index') }}"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition hover:bg-blue-700 {{ request()->routeIs('dashboard.bookings.*') ? 'bg-blue-700 text-white' : 'text-blue-100' }}"
                            @click="isSidebarOpen = false">
                            <i class="fas fa-calendar text-blue-200"></i>
                            <span>Booking Saya</span>
                        </a>
                    </div>
                @endhasrole

                <div>
                    <p class="mb-2 px-2 text-xs font-semibold uppercase tracking-wider text-blue-200/90">Akun</p>
                    <a href="{{ route('dashboard.profile.edit') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition hover:bg-blue-700 {{ request()->routeIs('dashboard.profile.*') ? 'bg-blue-700 text-white' : 'text-blue-100' }}"
                        @click="isSidebarOpen = false">
                        <i class="fas fa-user text-blue-200"></i>
                        <span>Profil</span>
                    </a>
                </div>
            </nav>

            <div class="mt-6 border-t border-blue-700/60 pt-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold text-blue-100 transition hover:bg-blue-700 hover:text-white">
                        <i class="fas fa-sign-out-alt text-blue-200"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
