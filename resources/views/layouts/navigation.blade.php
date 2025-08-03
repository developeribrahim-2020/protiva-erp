<nav x-data="{ open: false }" class="bg-blue-800 text-white shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-white" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('home')" target="_blank">
                        {{ __('View Website') }}
                    </x-nav-link>

                    {{-- Academics Dropdown --}}
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger"><button class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('academics.*') ? 'border-yellow-400' : 'border-transparent' }} text-sm font-medium text-white hover:border-yellow-300 transition"><div>Academics</div><div class="ms-1"><svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div></button></x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('academics.students.index')">{{ __('Students') }}</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    {{-- ... (অন্যান্য ড্রপডাউনগুলোও একইভাবে স্টাইল করা হবে) ... --}}
                </div>
            </div>
            
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-700 hover:bg-blue-600 transition">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1"><svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">@csrf<x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link></form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav><nav x-data="{ open: false }" class="bg-blue-800 text-white shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-white" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('home')" target="_blank">
                        {{ __('View Website') }}
                    </x-nav-link>

                    {{-- Academics Dropdown --}}
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger"><button class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('academics.*') ? 'border-yellow-400' : 'border-transparent' }} text-sm font-medium text-white hover:border-yellow-300 transition"><div>Academics</div><div class="ms-1"><svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div></button></x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('academics.students.index')">{{ __('Students') }}</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    {{-- ... (অন্যান্য ড্রপডাউনগুলোও একইভাবে স্টাইল করা হবে) ... --}}
                </div>
            </div>
            
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-700 hover:bg-blue-600 transition">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1"><svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">@csrf<x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link></form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>