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
                            <button @click="markReturned(loan.id)" class="text-yellow-600 hover:underline">
                                Mark Returned
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </LibrarianLayout>
</template>

<script setup>
import { Head, usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import LibrarianLayout from '@/Layouts/LibrarianLayout.vue';

const { props } = usePage();
const loans = props.value.loans;

function markReturned(id) {
    if (!confirm('Mark returned?')) return;
    Inertia.put(`/librarians/loans/${id}/return`);
}
</script>