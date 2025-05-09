<template>
    <AuthenticatedLayout>

        <Head title="Book Catalog" />

        <div class="max-w-7xl mx-auto p-6">
            <!-- Header -->
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-4 sm:mb-0">
                    Book Catalog
                </h2>
                <div class="text-gray-600 text-sm">
                    Showing <span class="font-medium">{{ books.data.length }}</span> on this page
                    <template v-if="books.meta?.total !== undefined">
                        out of <span class="font-medium">{{ books.meta.total }}</span> filtered books
                    </template>
                </div>
            </div>

            <!-- Search & Filters Panel -->
            <div class="bg-white p-4 rounded-lg shadow mb-8 flex flex-wrap gap-4 border border-gray-200">
                <!-- Search Input -->
                <div class="flex-grow min-w-[200px]">
                    <label for="search" class="sr-only">Search books</label>
                    <div class="relative text-gray-400 focus-within:text-gray-600">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l4.387
                       4.387a1 1 0 01-1.414 1.414l-4.387-4.387zM8
                       14a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <input id="search" v-model="filters.q" @input="getBooks" type="search"
                            placeholder="Search by Title, ISBN, Publisher..." class="block w-full border border-gray-300 rounded-md py-2 pl-10 pr-4
                       focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>
                </div>

                <!-- Category Filter -->
                <select v-model="filters.category" @change="getBooks" class="border border-gray-300 rounded-md py-2 px-3
                   focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Categories</option>
                    <option v-for="c in categories" :key="c.id" :value="c.id">
                        {{ c.name }}
                    </option>
                </select>

                <!-- Author Filter -->
                <select v-model="filters.author" @change="getBooks" class="border border-gray-300 rounded-md py-2 px-3
                   focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Authors</option>
                    <option v-for="a in authors" :key="a.id" :value="a.id">
                        {{ a.name }}
                    </option>
                </select>

                <!-- Availability Filter -->
                <select v-model="filters.availability" @change="getBooks" class="border border-gray-300 rounded-md py-2 px-3
                   focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Statuses</option>
                    <option value="1">Available</option>
                    <option value="0">Checked Out</option>
                </select>
            </div>

            <!-- Book Cards Grid -->
            <div v-if="books.data.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <BookCard v-for="book in books.data" :key="book.id" :book="book"
                    class="transform hover:scale-105 transition" />
            </div>
            <div v-else class="text-center py-16 text-gray-500">
                No books found matching your criteria.
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                <Pagination :links="books.links" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, usePage } from '@inertiajs/inertia-vue3';
import { reactive, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Pages/Components/Pagination.vue';
import BookCard from '@/Pages/Components/BookCard.vue';

// Grab Inertia’s page object
const page = usePage();

// Computed props so Vue updates when Inertia pushes new data
const books = computed(() => page.props.value.books);
const categories = computed(() => page.props.value.categories);
const authors = computed(() => page.props.value.authors);

// Reactive filters initialized from props
const filters = reactive({ ...page.props.value.filters });

// Fire off an Inertia visit with the current filters
function getBooks() {
    Inertia.get('/books', { ...filters }, {
        preserveState: true,
        preserveScroll: true,
    });
}
</script>

<style scoped>
/* Additional styling tweaks can go here */
</style>