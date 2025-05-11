<template>
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900">New Arrivals</h2>
            <p class="mt-2 text-gray-600">Check out the very latest additions to our collection.</p>
        </div>
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <BookCard v-for="book in books" :key="book.id" :book="book" />
        </div>
        <div class="mt-8 text-center">
            <Link href="/books"
                class="px-6 py-3 bg-indigo-500 text-white font-semibold rounded-full shadow hover:bg-indigo-600 transition">
            View All Books
            </Link>
        </div>
    </section>
</template>

<script setup>
import { defineProps } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import BookCard from '@/Pages/Components/BookCard.vue';

const props = defineProps({
    books: Array,
});
</script>