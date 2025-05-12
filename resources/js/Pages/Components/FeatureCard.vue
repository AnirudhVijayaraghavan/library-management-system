<template>
    <div class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition">
        <div class="text-indigo-600 text-4xl mb-4">{{ icon }}</div>
        <h3 class="text-xl font-semibold mb-2">{{ title }}</h3>
        <p class="text-gray-500">{{ description }}</p>
    </div>
</template>

<script setup>
defineProps({
    icon: String,
    title: String,
    description: String,
});
</script>