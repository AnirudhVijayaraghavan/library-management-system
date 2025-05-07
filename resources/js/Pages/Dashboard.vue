<template>
    <AuthenticatedLayout>

        <Head title="Dashboard" />

        <div class="max-w-7xl mx-auto p-6">
            <!-- Welcome + Stats -->
            <h1 class="text-2xl font-bold mb-6">Welcome back, {{ user.name }}!</h1>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                <div class="p-4 bg-white rounded-lg shadow">
                    <h2 class="text-lg font-medium">Total Books</h2>
                    <p class="text-3xl">{{ stats.totalBooks }}</p>
                </div>
                <div class="p-4 bg-white rounded-lg shadow">
                    <h2 class="text-lg font-medium">Books Borrowed</h2>
                    <p class="text-3xl">{{ stats.borrowedBooks }}</p>
                </div>
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
import { Head } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BookCard from '@/Pages/Components/BookCard.vue';

const props = defineProps({
    user: Object,
    stats: Object,
    featuredBooks: Array,
});
</script>