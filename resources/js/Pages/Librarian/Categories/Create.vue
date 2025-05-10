<template>
    <LibrarianLayout>

        <Head title="Add Category" />
        <form @submit.prevent="submit" class="bg-white p-6 rounded shadow space-y-4">
            <h1 class="text-2xl font-bold">Add Category</h1>
            <div>
                <label class="block">Name</label>
                <input v-model="name" class="w-full border rounded p-2" />
                <p v-if="error" class="text-red-600">{{ error }}</p>
            </div>
            <button class="bg-indigo-600 text-white px-4 py-2 rounded">Save</button>
        </form>
    </LibrarianLayout>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import LibrarianLayout from '@/Layouts/LibrarianLayout.vue';

const form = useForm({ name: '' });

function submit() {
    form.post('/librarians/categories');
}

const error = form.errors.name;
</script>