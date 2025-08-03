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
    <body class="font-sans text-gray-900 antialiased">
        {{-- Navigation Bar with Primary Color --}}
        <nav class="bg-blue-800 text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="font-bold text-2xl text-white">{{ setting('school_name', config('app.name')) }}</a>
                    </div>
                    {{-- Desktop Menu --}}
                    <div class="hidden sm:flex sm:items-center sm:space-x-8">
                        <a href="/" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->is('/') ? 'border-yellow-400' : 'border-transparent' }} text-sm font-medium hover:border-yellow-300 transition">{{ __('messages.home') }}</a>
                        <a href="{{ route('about') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('about') ? 'border-yellow-400' : 'border-transparent' }} text-sm font-medium hover:border-yellow-300 transition">{{ __('messages.about') }}</a>
                        <a href="{{ route('contact') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('contact') ? 'border-yellow-400' : 'border-transparent' }} text-sm font-medium hover:border-yellow-300 transition">{{ __('messages.contact') }}</a>
                        <a href="{{ route('admission.form') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admission.form') ? 'border-yellow-400' : 'border-transparent' }} text-sm font-medium hover:border-yellow-300 transition">{{ __('messages.online_admission') }}</a>
                    </div>
                    {{-- Login and Language Switcher --}}
                    <div class="hidden sm:flex sm:items-center">
                        <a href="{{ route('language.switch', 'en') }}" class="mr-4 text-sm font-medium {{ app()->getLocale() == 'en' ? 'font-bold text-yellow-400' : '' }}">English</a>
                        <a href="{{ route('language.switch', 'bn') }}" class="text-sm font-medium {{ app()->getLocale() == 'bn' ? 'font-bold text-yellow-400' : '' }}">বাংলা</a>
                        <a href="{{ route('login') }}" class="ml-6 bg-yellow-400 text-blue-900 px-4 py-2 rounded-md text-sm font-semibold hover:bg-yellow-500 transition">{{ __('messages.login') }}</a>
                    </div>
                </div>
            </div>
        </nav>

        <main class="bg-gray-100">
            {{ $slot }}
        </main>

        {{-- Footer with Primary Color --}}
        <footer class="bg-blue-800 text-white">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 text-center text-sm">
                © {{ date('Y') }} {{ setting('school_name', config('app.name')) }}. All rights reserved. | Developed by <a href="https://developeribrahim.com" target="_blank" class="font-semibold text-yellow-400 hover:underline">Developer Ibrahim</a>
            </div>
        </footer>
        
        @livewireScripts
    </body>
</html>