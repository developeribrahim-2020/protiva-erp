<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        @if ($applicationSubmitted)
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Application Submitted!</strong>
                <span class="block sm:inline">Thank you, your application has been received successfully. We will contact you soon.</span>
            </div>
        @else
            <form wire:submit.prevent="submitApplication" class="space-y-8 bg-white p-8 shadow-lg rounded-lg">
                <!-- Form sections here -->
                <button type="submit" class="w-full px-6 py-3 bg-indigo-600 text-white font-bold rounded-lg">Submit Application</button>
            </form>
        @endif
    </div>
</div>