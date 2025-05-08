<template>
    <AuthenticatedLayout>

        <Head title="Books" />

        <!-- Search & Filters -->
        <div class="flex flex-wrap gap-4 mb-6">
            <input v-model="filters.q" @input="getBooks" placeholder="Search title…"
                class="border rounded px-3 py-2 flex-grow" />

            <select v-model="filters.category" @change="getBooks" class="border rounded px-3 py-2">
                <option value="">All Categories</option>
                <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
            </select>

            <select v-model="filters.author" @change="getBooks" class="border rounded px-3 py-2">
                <option value="">All Authors</option>
                <option v-for="a in authors" :key="a.id" :value="a.id">{{ a.name }}</option>
            </select>

            <!-- … other filters & sorts … -->

            <button @click="getBooks" type="button" class="bg-indigo-600 text-white px-4 py-2 rounded">
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
import { reactive, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Pages/Components/Pagination.vue';
import BookCard from '@/Pages/Components/BookCard.vue';

// Grab the reactive page object
const page = usePage();

// Wrap page.props in computed so they update when Inertia pushes new props
const books = computed(() => page.props.value.books);
const categories = computed(() => page.props.value.categories);
const authors = computed(() => page.props.value.authors);

// Make filters reactive (initial values come from props)
const filters = reactive({ ...page.props.value.filters });

// Your search function
function getBooks() {
    Inertia.get(
        '/books',
        { ...filters },
        { preserveState: true, preserveScroll: true }
    );
}
</script>