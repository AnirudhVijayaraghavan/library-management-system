<template>
    <nav aria-label="Pagination" class="flex justify-center space-x-2 mt-4">
        <template v-for="(page, idx) in links" :key="idx">
            <Link v-if="page.url" :href="page.url" class="px-4 py-2 border rounded text-sm"
                :class="page.active ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 hover:bg-gray-100'"
                v-html="page.label">
            </Link>
            <span v-else class="px-4 py-2 border rounded text-sm text-gray-400" v-html="page.label"></span>
        </template>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    links: {
        type: Array,
        required: true,
    },
});
</script>