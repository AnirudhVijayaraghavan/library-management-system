<template>
    <div class="flex h-screen bg-gray-50 overflow-hidden">
        <Notifications class="mt-12 -mr-3" />
        <!-- Mobile sidebar -->
        <transition name="fade">
            <aside v-if="mobileOpen" class="fixed inset-0 z-40 flex md:hidden">
                <div class="relative flex flex-col w-64 bg-white border-r shadow-xl">
                    <div class="h-16 flex items-center justify-between px-4 border-b">
                        <span class="text-xl font-bold">MyLibrary CMS</span>
                        <button @click="mobileOpen = false" class="p-1 rounded hover:bg-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto">
                        <Link href="/librarians/books" class="block px-3 py-2 rounded hover:bg-gray-200">
                        Books
                        </Link>
                        <Link href="/librarians/books/create" class="block px-3 py-2 rounded hover:bg-gray-200">
                        Add Book
                        </Link>
                    </nav>
                </div>
                <div @click="mobileOpen = false" class="w-full"></div>
            </aside>
        </transition>

        <!-- Desktop sidebar -->
        <aside class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-white border-r">
                <div class="h-16 flex items-center justify-center text-2xl font-bold border-b">
                    MyLibrary CMS
                </div>
                <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto">
                    <Link href="/librarians/books" class="block px-3 py-2 rounded hover:bg-gray-200">
                    Books
                    </Link>
                    <Link href="/librarians/books/create" class="block px-3 py-2 rounded hover:bg-gray-200">
                    Add Book
                    </Link>
                </nav>
            </div>
        </aside>

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Header -->
            <header class="flex items-center justify-between px-4 py-2 bg-white border-b">
                <div class="flex items-center">
                    <button class="md:hidden p-1 mr-2 rounded hover:bg-gray-200" @click="mobileOpen = true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <Link href="/" class="text-xl font-bold text-gray-800 hover:text-gray-900">
                    MyLibrary
                    </Link>
                </div>
                <slot name="headerActions" />
            </header>

            <!-- Page content -->
            <main class="flex-1 overflow-y-auto p-6">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
const mobileOpen = ref(false);
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>