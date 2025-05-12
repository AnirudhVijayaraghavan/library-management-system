<template>
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 text-center mb-8" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-gray-900">New Arrivals</h2>
            <p class="mt-2 text-gray-600">Check out the latest additions.</p>
        </div>
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div v-for="(book, i) in books" :key="book.id" data-aos="fade-up" :data-aos-delay="100 + i * 100">
                <BookCard :book="book" />
            </div>
        </div>
    </section>
</template>

<script setup>
import { defineProps } from 'vue';
import BookCard from '@/Pages/Components/BookCard.vue';

const props = defineProps({ books: Array });
</script>