<!-- resources/js/Pages/Books/Show.vue -->
<template>
    <AuthenticatedLayout>

        <Head :title="book.title" />

        <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow mt-8">
            <div class="flex flex-col md:flex-row md:space-x-6">
                <!-- Cover -->
                <img v-if="book.cover_image" :src="book.cover_image" :alt="`Cover of ${book.title}`"
                    class="w-full md:w-1/3 object-cover rounded-md" />

                <!-- Info -->
                <div class="mt-4 md:mt-0 flex-1">
                    <h1 class="text-3xl font-bold mb-2">{{ book.title }}</h1>
                    <p class="text-gray-600 mb-4">by {{ book.author }}</p>
                    <p class="text-gray-700 mb-6">{{ book.description }}</p>

                    <ul class="space-y-1 text-gray-700 mb-6">
                        <li><strong>Publisher:</strong> {{ book.publisher }}</li>
                        <li><strong>Published:</strong> {{ book.publication_date }}</li>
                        <li><strong>Category:</strong> {{ book.category }}</li>
                        <li><strong>ISBN:</strong> {{ book.isbn }}</li>
                        <li><strong>Pages:</strong> {{ book.page_count }}</li>
                    </ul>

                    <!-- Availability Badge -->
                    <div class="flex items-center mb-6">
                        <span class="text-indigo-600 font-semibold">
                            Average Rating: {{ book.average_rating ?? '—' }}
                        </span>
                        <span class="ml-1 text-sm text-gray-500">/5</span>
                        <span class="ml-auto px-3 py-1 text-xs rounded" :class="book.is_available
                            ? 'bg-green-100 text-green-800'
                            : 'bg-red-100 text-red-800'">
                            {{ book.is_available ? 'Available' : 'Checked out' }}
                        </span>
                    </div>

                    <Link href="/books" class="inline-block text-indigo-600 hover:underline">
                    ← Back to all books
                    </Link>
                </div>
            </div>

            <!-- Customer Action Button -->
            <div class="mt-8">
                <button v-if="user?.role === 'customer'" @click="book.is_available ? checkout() : null" :class="[
                    'px-4 py-2 rounded font-medium',
                    book.is_available
                        ? 'bg-green-600 hover:bg-green-700 text-white'
                        : 'bg-gray-300 text-gray-700 cursor-default'
                ]">
                    <template v-if="book.is_available">Check Out</template>
                    <template v-else>
                        Currently Borrowed
                        <span v-if="book.due_at" class="ml-2 font-normal">
                            (Due: {{ book.due_at }})
                        </span>
                    </template>
                </button>
            </div>

            <!-- Reviews -->
            <div class="mt-8">
                <h2 class="text-2xl font-semibold mb-4">Customer Reviews</h2>
                <template v-if="book.reviews.length">
                    <div v-for="review in book.reviews" :key="review.id" class="p-4 bg-gray-50 rounded-md mb-4">
                        <p class="font-medium">{{ review.user.name }} says:</p>
                        <p class="text-yellow-500">
                            {{ '★'.repeat(review.rating) + '☆'.repeat(5 - review.rating) }}
                        </p>
                        <p class="mt-2 text-gray-700">“{{ review.comment }}”</p>
                    </div>
                </template>
                <p v-else class="text-gray-500">No reviews yet.</p>
            </div>

            <!-- Checkout Success Modal -->
            <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm">
                    <h3 class="text-xl font-semibold mb-4">Book Checked Out!</h3>
                    <p class="mb-6">
                        You have successfully borrowed this book. It is due on
                        <strong>{{ modalDueDate }}</strong>.
                    </p>
                    <p class="mb-6">
                        Please ensure you : 
                        <li>return the book on time, and in good condition.</li>
                        <li>return the book <strong>in-person</strong>, to the library, so that a librarian can mark it as returned.</li>
                    </p>
                    <button @click="closeModal" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                        OK
                    </button>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import { defineProps, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

// Receive the book prop
const { book } = defineProps({ book: Object });

// Access shared user from Inertia
const page = usePage();
const user = page.props.value.auth?.user || null;

// modal state
const showModal = ref(false);
const modalDueDate = ref('');

// checkout action
function checkout() {
    // compute the due date client-side to show immediately
    const due = new Date();
    due.setDate(due.getDate() + 5);
    modalDueDate.value = due.toISOString().slice(0, 10);

    // send request to back end
    Inertia.post(
        `/books/${book.id}/checkout`,
        {},
        {
            onSuccess: () => {
                // show modal, then leave the page data stale until user closes
                showModal.value = true;
            },
        }
    );
}
// close modal & refresh so the UI shows “checked out” state
function closeModal() {
    showModal.value = false;
    Inertia.reload();
}
// Customer return
// function returnBook() {
//     Inertia.put(
//         `/books/${book.id}/return`,
//         {},
//         {
//             onSuccess: () => {
//                 Inertia.reload();
//             },
//         }
//     );
// }
</script>

<style scoped>
/* Add any additional scoped styles here */
</style>