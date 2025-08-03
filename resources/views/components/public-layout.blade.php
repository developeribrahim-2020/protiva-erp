<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Protiva ERP') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <nav class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="font-bold text-xl">{{ config('app.name') }}</a>
                    </div>
                    <div class="hidden sm:flex sm:space-x-8">
                        <a href="/" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('/') ? 'border-indigo-500' : 'border-transparent' }}">Home</a>
                        <a href="{{ route('about') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('about') ? 'border-indigo-500' : 'border-transparent' }}">About</a>
                        <a href="{{ route('contact') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('contact') ? 'border-indigo-500' : 'border-transparent' }}">Contact</a>
                        <a href="{{ route('admission.form') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admission.form') ? 'border-indigo-500' : 'border-transparent' }}">Online Admission</a>
                    </div>
                    <div class="hidden sm:flex sm:items-center">
                        <a href="{{ route('login') }}" class="text-sm font-medium">Login</a>
                    </div>
                </div>
            </div>
        </nav>

        <main class="bg-gray-100">
            {{ $slot }}
        </main>

        <footer class="bg-gray-800 text-white">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 text-center text-sm">
                © {{ date('Y') }} {{ config('app.name') }}. | Developed by <a href="https://developeribrahim.com" target="_blank" class="font-semibold text-indigo-400 hover:underline">Developer Ibrahim</a>
            </div>
        </footer>
        
        @livewireScripts
    </body>
</html>