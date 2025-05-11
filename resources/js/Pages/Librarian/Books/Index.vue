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
                            <!-- Delete -->
                            <button class="text-red-600 hover:underline"
                                @click="confirmDestroy(book.id)">Delete</button>
                            <!-- Mark Returned -->
                            <button v-if="book.loan_id" class="text-yellow-600 hover:underline"
                                @click="confirmReturn(book.loan_id)">Mark Returned</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-4">
                <Pagination :links="books.links" />
            </div>
        </div>
        <!-- Delete Confirmation Modal -->
        <Modal v-model:modelValue="showDestroyModal" title="Confirm Delete">
            <p>Are you sure you want to delete this book forever?</p>
            <template #footer>
                <button @click="showDestroyModal = false" class="mr-2 px-4 py-2 rounded border">Cancel</button>
                <button @click="destroy()"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Delete</button>
            </template>
        </Modal>

        <!-- Return Confirmation Modal -->
        <Modal v-model:modelValue="showReturnModal" title="Confirm Return">
            <p>Mark this book as returned?</p>
            <template #footer>
                <button @click="showReturnModal = false" class="mr-2 px-4 py-2 rounded border">Cancel</button>
                <button @click="markReturned()"
                    class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded">Yes, Return</button>
            </template>
        </Modal>
    </LibrarianLayout>
</template>

<script setup>
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import LibrarianLayout from '@/Layouts/LibrarianLayout.vue';
import Pagination from '@/Pages/Components/Pagination.vue';
import { ref } from 'vue';
import Modal from '@/Pages/Components/Modal.vue';

const { props } = usePage();
const books = props.value.books;

// State for delete modal
const showDestroyModal = ref(false);
let deleteId = null;

function confirmDestroy(id) {
    deleteId = id;
    showDestroyModal.value = true;
}
function destroy() {
    Inertia.delete(
        `/librarians/books/${deleteId}`,
        {},
        { preserveState: true }
    );
    showDestroyModal.value = false;
}

// State for return modal
const showReturnModal = ref(false);
let returnLoanId = null;

function confirmReturn(loanId) {
    returnLoanId = loanId;
    showReturnModal.value = true;
}
function markReturned() {
    Inertia.put(
        `/librarians/loans/${returnLoanId}/return`,
        {},
        { preserveState: true, onSuccess: () => Inertia.reload() }
    );
    showReturnModal.value = false;
}
</script>