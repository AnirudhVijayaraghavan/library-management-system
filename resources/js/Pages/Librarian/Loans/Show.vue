<template>
    <AuthenticatedLayout>

        <Head title="Current Loans" />

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-2xl font-extrabold mb-6">Current Loans</h1>

            <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                <article v-for="loan in loans" :key="loan.id"
                    class="bg-white rounded-lg shadow hover:shadow-lg transition p-6">
                    <h2 class="text-lg font-semibold">{{ loan.book_title }}</h2>

                    <dl class="mt-4 space-y-2 text-gray-700">
                        <!-- Borrowed & Due -->
                        <div>
                            <dt class="font-medium inline">Borrowed:</dt>
                            <dd class="inline"> {{ loan.borrowed_at }} </dd>
                        </div>
                        <div>
                            <dt class="font-medium inline">Due:</dt>
                            <dd class="inline"> {{ loan.due_at }} </dd>
                        </div>

                        <!-- Customer Info -->
                        <div>
                            <dt class="font-medium inline">Customer:</dt>
                            <dd class="inline">
                                {{ loan.customer.name }} ({{ loan.customer.email }})
                            </dd>
                        </div>

                        <!-- Days Until / Late -->
                        <div v-if="loan.days_late > 0">
                            <dt class="font-medium inline text-red-600">Days Late:</dt>
                            <dd class="inline text-red-600">{{ loan.days_late }}</dd>
                        </div>
                        <div v-else>
                            <dt class="font-medium inline">Days Until Due:</dt>
                            <dd class="inline">{{ loan.days_until_due }}</dd>
                        </div>
                    </dl>
                </article>
            </div>

            <p v-if="loans.length === 0" class="mt-8 text-center text-gray-500">
                No active loans to show.
            </p>
        </section>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, usePage } from '@inertiajs/inertia-vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const page = usePage().props.value
const loans = page.loans || []
</script>
