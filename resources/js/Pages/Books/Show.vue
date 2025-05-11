<!-- resources/js/Pages/Books/Show.vue -->
<template>
    <AuthenticatedLayout>

        <Head :title="book.title" />

        <!-- Hero: Cover + Info -->
        <section class="max-w-5xl mx-auto mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Cover -->
            <div class="md:col-span-1">
                <img v-if="book.cover_image" :src="book.cover_image" :alt="`Cover of ${book.title}`"
                    class="w-full h-auto rounded-lg shadow-lg object-cover" />
            </div>

            <!-- Info -->
            <div class="md:col-span-2 space-y-4">
                <h1 class="text-4xl font-extrabold">{{ book.title }}</h1>
                <p class="text-lg text-gray-600">by <span class="font-medium">{{ book.author }}</span></p>
                <p class="text-gray-700 leading-relaxed">{{ book.description }}</p>

                <!-- Details List -->
                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-gray-700">
                    <li><strong>Publisher:</strong> {{ book.publisher || '—' }}</li>
                    <li><strong>Published:</strong> {{ book.publication_date || '—' }}</li>
                    <li><strong>Category:</strong> {{ book.category }}</li>
                    <li><strong>ISBN:</strong> {{ book.isbn }}</li>
                    <li><strong>Pages:</strong> {{ book.page_count }}</li>
                </ul>

                <!-- Availability & Rating -->
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-1">
                        <template v-for="i in 5" :key="i">
                            <svg v-if="i <= (book.average_rating || 0)" xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.178c.969 0 1.371 1.24.588 1.81l-3.384 2.458a1 1 0 00-.364 1.118l1.287 3.97c.3.921-.755 1.688-1.54 1.118l-3.384-2.458a1 1 0 00-1.175 0l-3.384 2.458c-.784.57-1.838-.197-1.54-1.118l1.287-3.97a1 1 0 00-.364-1.118L2.049 9.397c-.783-.57-.38-1.81.588-1.81h4.178a1 1 0 00.95-.69l1.286-3.97z" />
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.178c.969 0 1.371 1.24.588 1.81l-3.384 2.458a1 1 0 00-.364 1.118l1.287 3.97c.3.921-.755 1.688-1.54 1.118l-3.384-2.458a1 1 0 00-1.175 0l-3.384 2.458c-.784.57-1.838-.197-1.54-1.118l1.287-3.97a1 1 0 00-.364-1.118L2.049 9.397c-.783-.57-.38-1.81.588-1.81h4.178a1 1 0 00.95-.69l1.286-3.97z" />
                            </svg>
                        </template>
                        <span class="ml-2 text-gray-600">
                            {{ book.average_rating ? book.average_rating.toFixed(1) + '/5' : '—/5' }}
                        </span>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-medium" :class="book.is_available
                        ? 'bg-green-100 text-green-800'
                        : 'bg-red-100 text-red-800'">
                        {{ book.is_available ? 'Available' : 'Checked out' }}
                        <span v-if="!book.is_available && book.due_at" class="ml-1 font-normal">
                            (Due {{ book.due_at }})
                        </span>
                    </span>
                </div>

                <!-- Action Button -->
                <div class="mt-6">
                    <button v-if="user?.role === 'customer'" @click="book.is_available && checkout()"
                        :disabled="!book.is_available" class="inline-flex items-center px-6 py-3 rounded-full font-semibold text-white 
                     transition disabled:bg-gray-300 disabled:cursor-not-allowed
                     bg-green-600 hover:bg-green-700">
                        <svg v-if="book.is_available" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path d="M4 3a1 1 0 000 2h2v10H4a1 1 0 100 2h12a1 1 0 100-2h-2V5h2a1 1 0 100-2H4z" />
                        </svg>
                        {{ book.is_available ? 'Check Out' : 'Unavailable' }}
                    </button>
                </div>
            </div>
        </section>

        <!-- Reviews & Form -->
        <section class="max-w-5xl mx-auto mt-12">

            <!-- Reviews List -->
            <div>
                <h2 class="text-3xl font-bold mb-6">Customer Reviews</h2>

                <div class="space-y-6">
                    <article v-for="review in book.reviews" :key="review.id"
                        class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                        <!-- Header: stars + reviewer -->
                        <header class="flex items-center justify-between mb-3">
                            <!-- Stars -->
                            <div class="flex items-center space-x-1">
                                <template v-for="n in 5" :key="n">
                                    <svg xmlns="http://www.w3.org/2000/svg" :class="[
                                        'h-5 w-5',
                                        n <= review.rating ? 'text-yellow-500' : 'text-gray-200'
                                    ]" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.049 2.927c.3-.921 1.603-.921 1.902 
               0l1.286 3.97a1 1 0 00.95.69h4.178c.969 
               0 1.371 1.24.588 1.81l-3.384 
               2.458a1 1 0 00-.364 1.118l1.287 
               3.97c.3.921-.774 1.688-1.553 
               1.118l-3.383-2.458a1 1 0 
               00-1.176 0l-3.383 
               2.458c-.779.57-1.853-.197-1.553-1.118l1.287-3.97a1 
               1 0 00-.364-1.118L2.049 
               9.397c-.783-.57-.38-1.81.588-1.81h4.178a1 1 
               0 00.95-.69l1.286-3.97z" />
                                    </svg>
                                </template>
                            </div>

                            <!-- Reviewer & Date -->
                            <div class="text-gray-600 text-sm">
                                <span class="font-medium">{{ review.user.name }}</span>
                                <span class="mx-1">•</span>
                                <time :datetime="review.created_at">{{ review.created_at }}</time>
                            </div>
                        </header>

                        <!-- Comment -->
                        <p class="text-gray-800 leading-relaxed">
                            {{ review.comment }}
                        </p>
                    </article>


                    <p v-if="!book.reviews.length" class="text-gray-500">
                        No reviews yet. Be the first to leave one!
                    </p>
                </div>
            </div>

            <!-- Review Form -->
            <div v-if="user?.role === 'customer'" class="mt-12 bg-white p-6 rounded-lg shadow">
                <h3 class="text-2xl font-semibold mb-4">Leave Your Review</h3>
                <form @submit.prevent="submitReview" class="space-y-4">
                    <!-- Interactive Star Rating -->
                    <div>
                        <label class="block font-medium mb-2">Your Rating</label>
                        <div class="flex items-center space-x-1">
                            <template v-for="n in 5" :key="n">
                                <svg @click="form.rating = n" xmlns="http://www.w3.org/2000/svg" :class="[
                                    'h-8 w-8 cursor-pointer transition-colors',
                                    n <= form.rating ? 'text-yellow-500' : 'text-gray-300'
                                ]" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.049 2.927c.3-.921 1.603-.921 1.902 
             0l1.286 3.97a1 1 0 00.95.69h4.178c.969 
             0 1.371 1.24.588 1.81l-3.384 
             2.458a1 1 0 00-.364 1.118l1.287 
             3.97c.3.921-.774 1.688-1.553 
             1.118l-3.383-2.458a1 1 0 
             00-1.176 0l-3.383 
             2.458c-.779.57-1.853-.197-1.553-1.118l1.287-3.97a1 
             1 0 00-.364-1.118L2.049 
             9.397c-.783-.57-.38-1.81.588-1.81h4.178a1 1 
             0 00.95-.69l1.286-3.97z" />
                                </svg>
                            </template>
                        </div>
                        <p v-if="form.errors.rating" class="mt-1 text-red-600 text-sm">
                            {{ form.errors.rating }}
                        </p>
                    </div>

                    <!-- Comment -->
                    <div>
                        <label class="block font-medium mb-2">Your Comment</label>
                        <textarea v-model="form.comment" rows="4"
                            class="w-full border rounded-lg p-3 focus:ring focus:ring-indigo-200"
                            placeholder="Tell us what you thought of the book…"></textarea>
                        <p v-if="form.errors.comment" class="mt-1 text-red-600 text-sm">
                            {{ form.errors.comment }}
                        </p>
                    </div>

                    <button type="submit" :disabled="form.processing"
                        class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full font-semibold">
                        Submit Review
                    </button>
                </form>
            </div>
        </section>

        <!-- Checkout Success Modal -->
        <Modal v-model:modelValue="showModal" title="Book Checked Out!">
            <p class="mb-4">
                You’ve successfully borrowed this book. <br />
                <strong>Due on {{ modalDueDate }}</strong>.
            </p>
            <ul class="list-disc list-inside text-gray-700 mb-4">
                <li>Return on time, in good condition</li>
                <li>Bring it back <strong>in person</strong> so a librarian can mark it returned</li>
            </ul>
            <template #footer>
                <button @click="closeModal"
                    class="inline-flex items-center px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded">
                    OK
                </button>
            </template>
        </Modal>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link, usePage, useForm } from '@inertiajs/inertia-vue3';
import { defineProps, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Modal from '@/Pages/Components/Modal.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

// Props & user
const { book } = defineProps({ book: Object });
const user = usePage().props.value.auth.user;

// Modal state
const showModal = ref(false);
const modalDueDate = ref('');

// Review form
const form = useForm({ rating: 0, comment: '' });
function submitReview() {
    form.post(
        `/books/${book.id}/reviews`,
        {
            preserveScroll: true,
            onSuccess: () => form.reset('rating', 'comment'),
        }
    );
}

// Checkout
function checkout() {
    const due = new Date();
    due.setDate(due.getDate() + 5);
    modalDueDate.value = due.toISOString().slice(0, 10);

    Inertia.post(
        `/books/${book.id}/checkout`,
        {},
        {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => (showModal.value = true),
        }
    );
}
function closeModal() {
    showModal.value = false;
    Inertia.reload();
}
</script>