<template>
    <LibrarianLayout>

        <Head title="Add Category" />

        <form @submit.prevent="submit" class="bg-white p-6 rounded shadow space-y-4">
            <h1 class="text-2xl font-bold">Add Category</h1>

            <div>
                <label class="block font-medium">Name</label>
                <!-- bind to form.name -->
                <input v-model="form.name" type="text" class="w-full border rounded p-2" />
                <!-- show validation error -->
                <p v-if="form.errors.name" class="text-red-600 text-sm">
                    {{ form.errors.name }}
                </p>
            </div>

            <button type="submit" :disabled="form.processing"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                Save
            </button>
        </form>
    </LibrarianLayout>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import LibrarianLayout from '@/Layouts/LibrarianLayout.vue';

// useForm gives us form.name, form.errors, form.post, etc.
const form = useForm({
    name: '',
});

function submit() {
    form.post('/librarians/categories', {
        onSuccess: () => {
            // optionally reset the form or show a message
        },
    });
}
</script>