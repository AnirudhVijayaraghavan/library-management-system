<template>
    <AuthenticatedLayout>

        <Head title="Books" />

        <!-- Search & Filters -->
        <div class="flex mb-6 space-x-4">
            <input v-model="filters.q" @keyup.enter="getBooks" type="text" placeholder="Search title..."
                class="border rounded px-3 py-2 flex-grow" />
            <select v-model="filters.category" @change="getBooks" class="border rounded px-3 py-2">
                <option value="">All Categories</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                    {{ cat.name }}
                </option>
            </select>
            <button @click="getBooks" class="bg-indigo-600 text-white px-4 rounded">
                Go
            </button>
        </div>

        <!-- Card Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <BookCard v-for="book in books.data" :key="book.id" :book="book" />
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            <Pagination :links="books.links" />
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, usePage } from '@inertiajs/inertia-vue3';
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Pages/Components/Pagination.vue';
import BookCard from '@/Pages/Components/BookCard.vue';  // ← import

const { props } = usePage();
const books = props.value.books;
const categories = props.value.categories;
const filters = reactive({ ...props.value.filters });

function getBooks() {
    Inertia.get('/books', filters, { preserveState: true, replace: true });
}
</script>