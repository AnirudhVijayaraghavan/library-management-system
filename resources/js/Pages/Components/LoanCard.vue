<template>
    <article class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition"
        :class="overdue ? 'border-2 border-red-400' : ''">
        <h3 class="font-semibold text-lg">{{ loan.book_title }}</h3>
        <dl class="mt-2 text-gray-700 space-y-1">
            <div>
                <dt class="inline font-medium">Borrowed:</dt>
                <dd class="inline">{{ loan.borrowed_at }}</dd>
            </div>
            <div>
                <dt class="inline font-medium">Due:</dt>
                <dd class="inline">{{ loan.due_at }}</dd>
            </div>
            <div v-if="loan.customer">
                <dt class="inline font-medium">Customer:</dt>
                <dd class="inline">{{ loan.customer }}</dd>
            </div>
            <div v-if="overdue">
                <dt class="inline font-medium text-red-600">Days Late:</dt>
                <dd class="inline text-red-600">{{ loan.days_late }}</dd>
            </div>
        </dl>
    </article>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    loan: { type: Object, required: true },
    overdue: { type: Boolean, default: false },
});
</script>
