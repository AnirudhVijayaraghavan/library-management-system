<script setup>
import Notifications from '@/Pages/Components/Notification.vue';
</script>

<template>
    <Notifications class="mt-12 -mr-3 z-10" />
    <div class="min-h-screen flex items-center justify-center bg-gray-50">

        <div class="w-full max-w-md p-6 bg-white shadow rounded-lg">
            <slot />
        </div>
    </div>
</template>