<template>
    <LibrarianLayout>

        <Head title="Add New Book" />

        <form @submit.prevent="submit" class="bg-white rounded shadow p-6 space-y-4">
            <h1 class="text-2xl font-bold">Add Book</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Title -->
                <div>
                    <label class="block font-medium">Title</label>
                    <input v-model="form.title" type="text" class="w-full border rounded p-2" />
                    <p v-if="form.errors.title" class="text-red-600 text-sm">{{ form.errors.title }}</p>
                </div>
                <!-- ISBN -->
                <div>
                    <label class="block font-medium">ISBN</label>
                    <input v-model="form.isbn" type="text" class="w-full border rounded p-2" />
                    <p v-if="form.errors.isbn" class="text-red-600 text-sm">{{ form.errors.isbn }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Author -->
                <div>
                    <label class="block font-medium">Author</label>
                    <select v-model="form.author_id" class="w-full border rounded p-2">
                        <option value="">Select...</option>
                        <option v-for="a in authors" :key="a.id" :value="a.id">{{ a.name }}</option>
                    </select>
                    <p v-if="form.errors.author_id" class="text-red-600 text-sm">{{ form.errors.author_id }}</p>
                </div>
                <!-- Category -->
                <div>
                    <label class="block font-medium">Category</label>
                    <select v-model="form.category_id" class="w-full border rounded p-2">
                        <option value="">Select...</option>
                        <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                    </select>
                    <p v-if="form.errors.category_id" class="text-red-600 text-sm">{{ form.errors.category_id }}</p>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block font-medium">Description</label>
                <textarea v-model="form.description" rows="3" class="w-full border rounded p-2"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Publisher -->
                <div>
                    <label class="block font-medium">Publisher</label>
                    <input v-model="form.publisher" type="text" class="w-full border rounded p-2" />
                </div>
                <!-- Publication Date -->
                <div>
                    <label class="block font-medium">Publication Date</label>
                    <input v-model="form.publication_date" type="date" class="w-full border rounded p-2" />
                </div>
            </div>

            <!-- Page count & Cover Image URL -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Page Count</label>
                    <input v-model="form.page_count" type="number" min="1" class="w-full border rounded p-2" />
                </div>
                <div>
                    <label class="block font-medium">Cover Image URL</label>
                    <input v-model="form.cover_image" type="url" class="w-full border rounded p-2" />
                </div>
            </div>

            <button type="submit" :disabled="form.processing"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                Create Book
            </button>
        </form>
    </LibrarianLayout>
</template>

<script setup>
import { Head, useForm, usePage } from '@inertiajs/inertia-vue3';
import LibrarianLayout from '@/Layouts/LibrarianLayout.vue';

const { props } = usePage();
const authors = props.value.authors;
const categories = props.value.categories;

const form = useForm({
    title: '',
    isbn: '',
    author_id: '',
    category_id: '',
    description: '',
    publisher: '',
    publication_date: '',
    page_count: '',
    cover_image: '',
});

function submit() {
    form.post('/librarians/books');
}
</script>