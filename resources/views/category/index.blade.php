<x-app-layout>
    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-8">

                    {{-- Header --}}
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-black text-gray-800 dark:text-gray-100 tracking-tight">
                                Category List
                            </h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Manage and organize your product categories
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('product.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm font-medium rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm transition-all">
                                ← Back to Products
                            </a>
                            <a href="{{ route('category.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-lg shadow-md transition-all border border-indigo-500 active:scale-95">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Category
                            </a>
                        </div>
                    </div>

                    {{-- Flash Message --}}
                    @if (session('success'))
                        <div class="max-w-md mb-6 flex items-center p-4 text-sm rounded-lg border shadow-sm transition-all duration-300 bg-green-50 text-green-800 border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-800">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                            </svg>
                            <span class="font-bold">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="max-w-md mb-6 p-4 text-sm rounded-lg bg-red-50 text-red-800 border border-red-200 dark:bg-red-900/30 dark:text-red-300 dark:border-red-800">
                            <span class="font-bold">{{ session('error') }}</span>
                        </div>
                    @endif

                    {{-- Table Card --}}
                    <div class="relative overflow-hidden shadow-inner rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-200/50 dark:bg-gray-700 dark:text-gray-300 font-black">
                                <tr>
                                    <th class="px-6 py-4 w-16">#</th>
                                    <th class="px-6 py-4">Category Name</th>
                                    <th class="px-6 py-4 text-center">Total Products</th>
                                    <th class="px-6 py-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($categories as $category)
                                    <tr class="bg-white dark:bg-gray-800 hover:bg-indigo-50/50 dark:hover:bg-indigo-900/20 transition-colors">
                                        <td class="px-6 py-4 font-medium text-gray-400">
                                            {{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}
                                        </td>
                                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white text-base">
                                            {{ $category->name }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center justify-center min-w-[2.5rem] px-2.5 py-1 bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400 rounded-full text-xs font-black shadow-sm border border-blue-200 dark:border-blue-800">
                                                {{ $category->products_count }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center justify-center gap-4">
                                                {{-- Form Delete yang sudah diperbaiki --}}
                                                <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Semua relasi produk mungkin akan terpengaruh.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-bold text-red-500 hover:text-red-700 dark:text-red-400 transition-colors bg-transparent border-none p-0 cursor-pointer">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-16 text-center text-gray-500 dark:text-gray-400">
                                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                            <span class="block italic font-medium">Belum ada kategori yang ditambahkan.</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if ($categories->hasPages())
                        <div class="mt-6">
                            {{ $categories->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>