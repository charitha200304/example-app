<x-layout.layout heading="Welcome">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Welcome to Our Application</h1>
            <p class="text-gray-600 mb-4">
                Thank you for visiting our application. This is the home page content.
            </p>
            <div class="mt-6">
                <a href="{{ route('about') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Learn More About Us
                </a>
            </div>
        </div>
    </div>
</x-layout.layout>
