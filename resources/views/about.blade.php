<x-layout.layout heading="About Us">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-800 mb-6">This is the About Us Page</h1>
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-gray-600 mb-4">
                Welcome to our about page. This is a simple example of using Laravel components.
            </p>
            <a href="{{ route('home') }}" class="text-blue-600 hover:underline">
                &larr; Back to Home
            </a>
        </div>
    </div>
</x-layout.layout>
