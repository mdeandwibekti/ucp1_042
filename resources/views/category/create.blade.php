<x-app-layout>
    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="mb-6 flex items-center gap-3">
                    <a href="{{ route('category.index') }}" class="text-gray-500 hover:text-gray-700">←</a>
                    <h2 class="text-xl font-bold">Add Category</h2>
                </div>

                <form action="{{ route('category.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                        <input type="text" name="name" placeholder="e.g. Electronic" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('category.index') }}" class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-50 text-sm">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-bold">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>