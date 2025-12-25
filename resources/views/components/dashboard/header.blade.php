<!-- Header -->
<header class="sticky top-0 z-40 w-full border-b border-gray-200 bg-white/80 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <!-- Left Section -->
        <div class="flex items-center gap-3">
            <!-- Mobile Menu Button -->
            <button type="button" @click="isSidebarOpen = !isSidebarOpen"
                class="inline-flex items-center justify-center rounded-lg border border-gray-200 bg-white p-2 text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 md:hidden"
                aria-label="Toggle sidebar">
                <i class="fas fa-bars text-lg"></i>
            </button>

            <div class="hidden h-6 w-px bg-gray-200 md:block" aria-hidden="true"></div>

            <div class="hidden md:block">
                <p class="text-sm font-semibold leading-none text-gray-900">Dashboard</p>
                <p class="mt-1 text-xs leading-none text-gray-500">{{ config('app.name') }}</p>
            </div>
        </div>

        <!-- Right Section -->
        <div class="flex items-center gap-3">
            <!-- User Menu -->
            <div class="relative" x-data="{ open: false }">
                <button type="button" @click="open = !open" @click.away="open = false"
                    class="flex items-center gap-3 rounded-lg border border-transparent p-2 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300"
                    aria-haspopup="menu" :aria-expanded="open">
                    <span class="sr-only">Open user menu</span>

                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-full border border-gray-200 bg-gray-100 text-gray-900 shadow-sm">
                        <span class="text-sm font-semibold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    </div>

                    <div class="hidden text-left sm:block">
                        <p class="max-w-[12rem] truncate text-sm font-medium leading-none text-gray-900">
                            {{ Auth::user()->name }}</p>
                        <p class="mt-1 max-w-[12rem] truncate text-xs leading-none text-gray-500">
                            {{ Auth::user()->email }}</p>
                    </div>

                    <i class="fas fa-chevron-down hidden text-xs text-gray-500 sm:block"></i>
                </button>

                <!-- Dropdown Menu -->
                <div x-cloak x-show="open" x-transition.origin.top.right
                    class="absolute right-0 mt-2 w-56 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lg"
                    role="menu" aria-label="User menu">
                    <a href="{{ route('dashboard.profile.edit') }}"
                        class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 transition hover:bg-gray-50"
                        role="menuitem">
                        <i class="fas fa-user text-gray-500"></i>
                        Profile
                    </a>

                    <div class="h-px bg-gray-200" aria-hidden="true"></div>

                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit"
                            class="flex w-full items-center gap-3 px-4 py-3 text-sm text-gray-700 transition hover:bg-gray-50"
                            role="menuitem">
                            <i class="fas fa-sign-out-alt text-gray-500"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
