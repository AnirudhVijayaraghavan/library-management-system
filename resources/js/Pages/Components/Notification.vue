<template>
    <div class="fixed top-4 right-4 z-50 flex flex-col space-y-4">
        <!-- Success Notification -->
        <transition name="slide-fade">
            <div v-if="showSuccess && flash.success"
                class="max-w-sm w-full bg-green-600 text-white font-medium rounded-lg shadow-lg p-4 flex items-start space-x-4">
                <div class="flex-1">{{ flash.success }}</div>
                <button @click="hideSuccess"
                    class="text-white hover:text-gray-200 font-bold text-xl leading-none focus:outline-none">
                    &times;
                </button>
            </div>
        </transition>

        <!-- Failure Notification -->
        <transition name="slide-fade">
            <div v-if="showFailure && flash.failure"
                class="max-w-sm w-full bg-red-600 text-white font-medium rounded-lg shadow-lg p-4 flex items-start space-x-4">
                <div class="flex-1">{{ flash.failure }}</div>
                <button @click="hideFailure"
                    class="text-white hover:text-gray-200 font-bold text-xl leading-none focus:outline-none">
                    &times;
                </button>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

// Grab shared flash props
const flash = usePage().props.value.flash;

// Local reactive state for visibility
const showSuccess = ref(!!flash.success);
const showFailure = ref(!!flash.failure);

// Hide functions
const hideSuccess = () => (showSuccess.value = false);
const hideFailure = () => (showFailure.value = false);

// Auto-hide after 5 seconds
onMounted(() => {
    if (flash.success) setTimeout(hideSuccess, 4000);
    if (flash.failure) setTimeout(hideFailure, 4000);
});
</script>

<style>
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 1.5s ease-out;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    opacity: 0;
    transform: translateY(-50px);
}
</style>