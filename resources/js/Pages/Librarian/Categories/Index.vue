<template>
    <LibrarianLayout>

        <Head title="Categories" />
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Categories</h1>
            <Link href="/librarians/categories/create" class="bg-indigo-600 text-white px-4 py-2 rounded">
            + New Category
            </Link>
        </div>
        <ul class="bg-white rounded shadow divide-y">
            <li v-for="c in categories" :key="c.id" class="p-3">{{ c.name }}</li>
        </ul>
    </LibrarianLayout>
</template>

<script setup>
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import LibrarianLayout from '@/Layouts/LibrarianLayout.vue';

const { props } = usePage();
const categories = props.value.categories;
</script>