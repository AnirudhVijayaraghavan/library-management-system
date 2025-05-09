<template>
    <LibrarianLayout>

        <Head title="Manage Books" />

        <div class="bg-white rounded shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">All Books</h1>
                <Link href="/librarians/books/create"
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                + New Book
                </Link>
            </div>

            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="p-2 border-b">ID</th>
                        <th class="p-2 border-b">Title</th>
                        <th class="p-2 border-b">Author</th>
                        <th class="p-2 border-b">Category</th>
                        <th class="p-2 border-b">Status</th>
                        <th class="p-2 border-b">Due Date</th>
                        <th class="p-2 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="book in books.data" :key="book.id" class="hover:bg-gray-100">
                        <td class="p-2 border-b">{{ book.id }}</td>
                        <td class="p-2 border-b">{{ book.title }}</td>
                        <td class="p-2 border-b">{{ book.author }}</td>
                        <td class="p-2 border-b">{{ book.category }}</td>
                        <td class="p-2 border-b">
                            <span :class="book.is_available
                                ? 'text-green-600'
                                : 'text-red-600'">
                                {{ book.is_available ? 'Available' : 'Loaned' }}
                            </span>
                        </td>
                        <td class="p-2 border-b">
                            {{ book.due_at ?? '—' }}
                        </td>
                        <td class="p-2 border-b space-x-2">
                            <Link :href="`/librarians/books/${book.id}/edit`" class="text-indigo-600 hover:underline">
                            Edit
                            </Link>
                            <button @click="destroy(book.id)" class="text-red-600 hover:underline">
                                Delete
                            </button>
                            <button v-if="!book.is_available" @click="markReturned(book.id)"
                                class="text-yellow-600 hover:underline">
                                Mark Returned
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-4">
                <Pagination :links="books.links" />
            </div>
        </div>
    </LibrarianLayout>
</template>

<script setup>
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import LibrarianLayout from '@/Layouts/LibrarianLayout.vue';
import Pagination from '@/Pages/Components/Pagination.vue';

const { props } = usePage();
const books = props.value.books;

function destroy(id) {
    if (!confirm('Delete this book forever?')) return;
    Inertia.delete(`/librarians/books/${id}`, {}, { preserveState: true });
}

function markReturned(id) {
    if (!confirm('Mark this book as returned?')) return;
    Inertia.put(`/librarians/books/${id}/return`, {}, { preserveState: true });
}
</script>