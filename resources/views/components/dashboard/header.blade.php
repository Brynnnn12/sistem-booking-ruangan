<!-- Header -->
<header class="">
    <div class="flex items-center justify-between px-6 py-4">
        <!-- Left Section -->
        <div class="flex items-center space-x-4">
            <!-- Mobile Menu Button -->
            <button @click="isSidebarOpen = !isSidebarOpen"
                class="md:hidden p-2 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="fas fa-bars text-lg"></i>
            </button>

            <nav aria-label="Breadcrumb">
                <ol class="flex items-center gap-1 text-sm text-gray-700">
                    <li>
                        <a href="#" class="block transition-colors hover:text-gray-900" aria-label="Home">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </a>
                    </li>

                    <li class="rtl:rotate-180">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </li>

                    <li>
                        <a href="#" class="block transition-colors hover:text-gray-900"> Category </a>
                    </li>

                    <li class="rtl:rotate-180">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </li>

                    <li>
                        <a href="#" class="block transition-colors hover:text-gray-900"> Product </a>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Right Section -->
        <div class="flex items-center space-x-4 z-50">
            <!-- User Menu -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false"
                    class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-sm">
                        <span class="font-bold text-white text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" x-transition
                    class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-[100]">
                    <a href="{{ route('dashboard.profile.edit') }}"
                        class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                        <i class="fas fa-user mr-3 text-gray-500"></i>
                        Profile
                    </a>
                    <hr class="my-1 border-gray-200">
                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                            <i class="fas fa-sign-out-alt mr-3"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
