<!-- Sidebar Desktop -->
<aside class="hidden w-64 shrink-0 border-r border-blue-900/30 bg-blue-800 text-white md:block">
    <div class="flex h-full flex-col p-4">
        <div class="mb-6 mt-2 flex items-center justify-center gap-2">
            <i class="fas fa-chart-line text-blue-200"></i>
            <span class="text-lg font-semibold text-white">Dashboard</span>
        </div>

        <nav class="flex-1 space-y-6">
            <div>
                <p class="mb-2 px-2 text-xs font-semibold uppercase tracking-wider text-blue-200/90">Dashboard</p>
                <a href="{{ route('dashboard.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition hover:bg-blue-700 {{ request()->routeIs('dashboard.index') ? 'bg-blue-700 text-white' : 'text-blue-100' }}">
                    <i class="fas fa-home text-blue-200"></i>
                    <span>Ringkasan</span>
                </a>
            </div>

            @role('Admin')
                <div>
                    <p class="mb-2 px-2 text-xs font-semibold uppercase tracking-wider text-blue-200/90">Manajemen</p>
                    <a href="{{ route('dashboard.employees.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition hover:bg-blue-700 {{ request()->routeIs('dashboard.employees.*') ? 'bg-blue-700 text-white' : 'text-blue-100' }}">
                        <i class="fas fa-users text-blue-200"></i>
                        <span>Pegawai</span>
                    </a>


                    <a href="{{ route('dashboard.rooms.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition hover:bg-blue-700 {{ request()->routeIs('dashboard.rooms.*') ? 'bg-blue-700 text-white' : 'text-blue-100' }}">
                        <i class="fas fa-building text-blue-200"></i>
                        <span>Ruangan</span>
                    </a>

                    <a href="{{ route('dashboard.bookings.index') }}"
                        class="mt-1 flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition hover:bg-blue-700 {{ request()->routeIs('dashboard.bookings.*') ? 'bg-blue-700 text-white' : 'text-blue-100' }}">
                        <i class="fas fa-calendar text-blue-200"></i>
                        <span>Semua Booking</span>
                    </a>
                </div>
            @endrole

            @role('Staff')
                <div>
                    <p class="mb-2 px-2 text-xs font-semibold uppercase tracking-wider text-blue-200/90">Booking</p>
                    <a href="{{ route('dashboard.bookings.create') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition hover:bg-blue-700 {{ request()->routeIs('dashboard.bookings.create') ? 'bg-blue-700 text-white' : 'text-blue-100' }}">
                        <i class="fas fa-plus text-blue-200"></i>
                        <span>Buat Booking</span>
                    </a>


                    <a href="{{ route('dashboard.bookings.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition hover:bg-blue-700 {{ request()->routeIs('dashboard.bookings.index') ? 'bg-blue-700 text-white' : 'text-blue-100' }}">
                        <i class="fas fa-calendar text-blue-200"></i>
                        <span>Booking Saya</span>
                    </a>

                </div>
            @endrole

            <div>
                <p class="mb-2 px-2 text-xs font-semibold uppercase tracking-wider text-blue-200/90">Akun</p>
                <a href="{{ route('dashboard.profile.edit') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition hover:bg-blue-700 {{ request()->routeIs('dashboard.profile.*') ? 'bg-blue-700 text-white' : 'text-blue-100' }}">
                    <i class="fas fa-user text-blue-200"></i>
                    <span>Profil</span>
                </a>
            </div>
        </nav>

        <div class="mt-6 border-t border-blue-700/60 pt-4">
            <div class="mb-3 flex items-center gap-3">
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-full border border-blue-700/60 bg-blue-700">
                    <span
                        class="text-sm font-semibold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                    <p class="truncate text-xs text-blue-200">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <x-partials.danger-button type="submit" class="w-full justify-center">
                    <i class="fas fa-sign-out-alt mr-2 text-xs"></i>
                    Logout
                </x-partials.danger-button>
            </form>
        </div>
    </div>
</aside>
