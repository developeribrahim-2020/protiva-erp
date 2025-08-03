<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ setting('school_name', config('app.name', 'Protiva ERP')) }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-800">
            
            {{-- Navigation Bar with Primary Color --}}
            @include('layouts.navigation')

            {{-- Page Heading --}}
            @if (isset($header))
                <header class="bg-white dark:bg-gray-700 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            {{-- Page Content --}}
            <main>
                {{ $slot }}
            </main>

            {{-- Footer (Optional for Admin Panel, but kept for consistency) --}}
            <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-8">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500 dark:text-gray-400">
                    © {{ date('Y') }} {{ setting('school_name', config('app.name', 'Protiva ERP')) }}. | Developed by <a href="https://developeribrahim.com" target="_blank" class="font-semibold text-blue-800 dark:text-yellow-400 hover:underline">Developer Ibrahim</a>
                </div>
            </footer>
        </div>
        
        @livewireScripts
    </body>
</html>