<template>
    <LibrarianLayout>

        <Head title="Active Loans" />
        <div class="bg-white p-6 rounded shadow">
            <h1 class="text-2xl font-bold mb-4">Current Loans</h1>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="p-2 border">Book</th>
                        <th class="p-2 border">Customer</th>
                        <th class="p-2 border">Borrowed</th>
                        <th class="p-2 border">Due</th>
                        <th class="p-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="loan in loans" :key="loan.id">
                        <td class="p-2 border">{{ loan.book_title }}</td>
                        <td class="p-2 border">{{ loan.user_name }}</td>
                        <td class="p-2 border">{{ loan.borrowed_at }}</td>
                        <td class="p-2 border">{{ loan.due_at }}</td>
                        <td class="p-2 border">
                            <button class="text-yellow-600 hover:underline" @click="confirmReturn(loan.id)">Mark
                                Returned</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Return Confirmation Modal -->
        <Modal v-model:modelValue="showReturnModal" title="Confirm Return">
            <p>Are you sure you want to mark this loan as returned?</p>
            <template #footer>
                <button @click="showReturnModal = false" class="mr-2 px-4 py-2 rounded border">Cancel</button>
                <button @click="markReturned()"
                    class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded">Yes, Return</button>
            </template>
        </Modal>
    </LibrarianLayout>
</template>

<script setup>
import { Head, usePage } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import LibrarianLayout from '@/Layouts/LibrarianLayout.vue';
import Modal from '@/Pages/Components/Modal.vue';

const { props } = usePage();
const loans = props.value.loans;

// Return modal state
const showReturnModal = ref(false);
let returnLoanId = null;

function confirmReturn(id) {
    returnLoanId = id;
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