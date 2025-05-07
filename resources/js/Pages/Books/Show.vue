<!-- resources/js/Pages/Books/Show.vue -->
<template>
    <AuthenticatedLayout>

        <Head :title="book.title" />

        <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow mt-8">
            <div class="flex flex-col md:flex-row md:space-x-6">
                <!-- Cover -->
                <img v-if="book.cover_image" :src="book.cover_image" :alt="`Cover of ${book.title}`"
                    class="w-full md:w-1/3 object-cover rounded-md" />

                <!-- Info -->
                <div class="mt-4 md:mt-0 flex-1">
                    <h1 class="text-3xl font-bold mb-2">{{ book.title }}</h1>
                    <p class="text-gray-600 mb-4">by {{ book.author }}</p>
                    <p class="text-gray-700 mb-6">{{ book.description }}</p>

                    <ul class="space-y-1 text-gray-700 mb-6">
                        <li><strong>Publisher:</strong> {{ book.publisher }}</li>
                        <li><strong>Published:</strong> {{ book.publication_date }}</li>
                        <li><strong>Category:</strong> {{ book.category }}</li>
                        <li><strong>ISBN:</strong> {{ book.isbn }}</li>
                        <li><strong>Pages:</strong> {{ book.page_count }}</li>
                    </ul>

                    <div class="flex items-center mb-6">
                        <span class="text-indigo-600 font-semibold">
                            {{ book.average_rating ?? '—' }}
                        </span>
                        <span class="ml-1 text-sm text-gray-500">/5</span>
                        <span class="ml-auto px-3 py-1 text-xs rounded" :class="book.is_available
                            ? 'bg-green-100 text-green-800'
                            : 'bg-red-100 text-red-800'">
                            {{ book.is_available ? 'Available' : 'Checked out' }}
                        </span>
                    </div>

                    <Link href="/books" class="inline-block text-indigo-600 hover:underline">
                    ← Back to all books
                    </Link>
                </div>
            </div>

            <!-- Reviews -->
            <div class="mt-8">
                <h2 class="text-2xl font-semibold mb-4">Customer Reviews</h2>
                <template v-if="book.reviews.length">
                    <div v-for="review in book.reviews" :key="review.id" class="p-4 bg-gray-50 rounded-md mb-4">
                        <p class="font-medium">{{ review.user.name }} says:</p>
                        <p class="text-yellow-500">
                            {{ '★'.repeat(review.rating) + '☆'.repeat(5 - review.rating) }}
                        </p>
                        <p class="mt-2 text-gray-700">“{{ review.comment }}”</p>
                    </div>
                </template>
                <p v-else class="text-gray-500">No reviews yet.</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { defineProps } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const { book } = defineProps({
    book: Object,
});
</script>