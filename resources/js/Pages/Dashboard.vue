<template>
    <AuthenticatedLayout>

        <Head title="Dashboard" />

        <div class="max-w-7xl mx-auto p-6">
            <!-- Welcome + Admin Button -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                <h1 class="text-2xl font-bold">
                    Welcome back, {{ user.name }}!
                </h1>

                <!-- Only visible to librarians -->
                <Link v-if="stats.role === 'librarian'" href="/librarians/books"
                    class="mt-4 sm:mt-0 inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                Admin Panel
                </Link>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                <div class="p-4 bg-white rounded-lg shadow">
                    <h2 class="text-lg font-medium">Total Books</h2>
                    <p class="text-3xl">{{ stats.totalBooks }}</p>
                </div>

                <!-- Borrowed Books (clickable) -->
                <Link href="/loans" class="block bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
                <h3 class="text-lg font-medium">Books Borrowed</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ stats.borrowedBooks }}</p>
                </Link>
                <div class="p-4 bg-white rounded-lg shadow">
                    <h2 class="text-lg font-medium">Your Role</h2>
                    <p class="text-3xl capitalize">{{ stats.role }}</p>
                </div>
            </div>

            <!-- Featured Books -->
            <section>
                <h2 class="text-xl font-semibold mb-4">Featured Books</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <BookCard v-for="book in featuredBooks" :key="book.id" :book="book" />
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { defineProps } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BookCard from '@/Pages/Components/BookCard.vue';

const props = defineProps({
    user: Object,
    stats: Object,
    featuredBooks: Array,
});
</script>