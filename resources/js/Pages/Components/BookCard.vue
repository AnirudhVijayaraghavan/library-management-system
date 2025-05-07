<template>
    <div class="p-4 bg-white rounded-lg shadow hover:shadow-lg transition">
        <Link :href="`/books/${book.id}`" class="block">
        <img v-if="book.cover_image" :src="book.cover_image" alt="" class="w-full h-48 object-cover rounded-md mb-4" />
        <h3 class="text-lg font-semibold">{{ book.title }}</h3>
        <p class="text-sm text-gray-500">{{ book.author }}</p>
        <p class="mt-2 text-gray-600 h-12 overflow-hidden">{{ book.description }}</p>
        <div class="mt-4 flex items-center">
            <span class="text-indigo-600 font-semibold">{{ book.average_rating ?? '—' }}</span>
            <span class="ml-1 text-sm text-gray-500">/5</span>
            <span class="ml-auto px-2 py-1 text-xs rounded"
                :class="book.is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                {{ book.is_available ? 'Available' : 'Checked out' }}
            </span>
        </div>
        </Link>
    </div>
</template>

<script setup>
defineProps({
    book: Object,
});
</script>