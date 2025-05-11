<template>
    <LibrarianLayout>

        <Head title="Authors" />

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Authors</h1>
            <Link href="/librarians/authors/create"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
            + New Author
            </Link>
        </div>

        <ul class="bg-white rounded shadow divide-y">
            <li v-for="author in authors" :key="author.id" class="p-3 hover:bg-gray-50">
                {{ author.name }}
            </li>
        </ul>
    </LibrarianLayout>
</template>

<script setup>
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import LibrarianLayout from '@/Layouts/LibrarianLayout.vue';

// Grab the authors array from the shared Inertia props
const { props } = usePage();
const authors = props.value.authors;
</script>