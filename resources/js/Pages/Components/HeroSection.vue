<template>
    <section class="relative bg-white overflow-hidden">
        <nav class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 flex justify-between h-16 items-center">
                <a href="/" class="text-2xl font-bold text-indigo-600">MyLibrary</a>
                <div>
                    <a href="/login" class="px-3 py-2 text-gray-700 hover:text-indigo-600">Login</a>
                    <a href="/register" class="ml-4 px-3 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Sign
                        Up</a>
                </div>
            </div>
        </nav>
        <div class="max-w-7xl mx-auto px-4 py-16 text-center lg:text-left">
            <h1 class="text-5xl font-extrabold text-gray-900">
                Your Gateway to <span class="text-indigo-600">Unlimited Knowledge</span>
            </h1>
            <p class="mt-4 text-lg text-gray-500 max-w-xl">
                Browse, borrow, and manage books effortlessly with our modern library system.
            </p>
            <div class="mt-6 flex justify-center lg:justify-start">
                <input v-model="query" type="text" placeholder="Search books..."
                    class="px-4 py-2 w-64 border rounded-l-md focus:ring-2 focus:ring-indigo-500" />
                <button @click="search" class="px-4 py-2 bg-indigo-600 text-white rounded-r-md hover:bg-indigo-700">
                    Search
                </button>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const query = ref('');
function search() {
    Inertia.get('/books/search', { q: query.value });
}
</script>