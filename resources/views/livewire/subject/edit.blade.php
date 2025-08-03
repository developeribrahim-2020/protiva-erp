<div>
    <div class="p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
        <h2 class="mb-4 text-2xl font-semibold">Edit Subject</h2>

        <form wire:submit="update">
            <div class="mb-4">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                <input type="text" wire:model="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                @error('name') <span class="mt-2 text-sm text-red-600">{{ '{{' }} $message {{ '}}' }}</span> @enderror
            </div>
            
            <div class="flex items-center space-x-4">
                <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Update</button>
                <a href="{{ '{{' }} route('subject.index') {{ '}}' }}" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Cancel</a>
            </div>
        </form>
    </div>
</div>