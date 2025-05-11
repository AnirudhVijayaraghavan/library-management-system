<template>
    <teleport to="body">
        <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100" leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
            <div v-if="modelValue" class="fixed inset-0 z-50 flex items-center justify-center p-4">
                <!-- backdrop -->
                <div class="fixed inset-0 bg-black bg-opacity-50" @click="$emit('update:modelValue', false)"></div>

                <!-- modal panel -->
                <div class="bg-white rounded-lg overflow-hidden shadow-xl z-10 w-full max-w-md">
                    <header class="flex items-center justify-between px-4 py-2 border-b">
                        <h3 class="text-lg font-semibold">{{ title }}</h3>
                        <button @click="$emit('update:modelValue', false)" class="text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </header>

                    <div class="p-4">
                        <slot />
                    </div>

                    <footer class="px-4 py-2 border-t text-right">
                        <slot name="footer">
                            <button @click="$emit('update:modelValue', false)"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                                Close
                            </button>
                        </slot>
                    </footer>
                </div>
            </div>
        </transition>
    </teleport>
</template>

<script setup>
import { defineProps } from 'vue';

defineProps({
    modelValue: { type: Boolean, required: true },
    title: { type: String, default: '' },
});
</script>