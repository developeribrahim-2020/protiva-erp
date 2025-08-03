<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Bulk Student Entry') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4 p-4 border-l-4 border-yellow-400 bg-yellow-50 dark:bg-gray-700/50">
                        <p class="font-bold">Instructions:</p>
                        <p class="text-sm">Paste student data below, one student per line. Use comma (,) to separate values.</p>
                        <p class="text-sm"><strong>Format:</strong> Roll, Name, Class-Section, Father's Name</p>
                        <p class="text-sm"><strong>Example:</strong> 1, John Doe, Play - Bely, Richard Doe</p>
                    </div>
                    
                    <form wire:submit.prevent="processEntry">
                        <textarea wire:model="textData" rows="20" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                        
                        <div class="mt-4">
                            <x-primary-button>Process Data</x-primary-button>
                        </div>
                    </form>
                    
                    @if(session()->has('message'))
                        <div class="mt-4 p-4 text-green-700 bg-green-100 rounded-lg">{{ session('message') }}</div>
                    @endif

                    @if($errorCount > 0)
                        <div class="mt-4">
                            <h3 class="font-bold text-red-600">Errors ({{ $errorCount }}):</h3>
                            <ul class="list-disc list-inside text-red-600 text-sm max-h-40 overflow-y-auto">
                                @foreach($errors as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>