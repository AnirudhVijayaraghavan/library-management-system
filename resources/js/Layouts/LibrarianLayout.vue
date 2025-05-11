<template>
    <div class="flex h-screen bg-gray-50 overflow-hidden">
        <!-- Notifications -->
        <Notifications class="mt-12 -mr-3" />

        <!-- Mobile sidebar -->
        <transition name="fade">
            <aside v-if="mobileOpen" class="fixed inset-0 z-40 flex md:hidden">
                <div class="relative flex flex-col w-64 bg-white border-r shadow-xl">
                    <div class="h-16 flex items-center justify-between px-4 border-b">
                        <span class="text-xl font-bold">MyLibrary CMS</span>
                        <button @click="mobileOpen = false" class="p-1 rounded hover:bg-gray-200">
                            <!-- close icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto">
                        <SidebarLink to="/dashboard" label="Dashboard" :active="isActive('/dashboard')" />
                        <SidebarLink to="/librarians/books" label="Books" :active="isBooksActive" />
                        <SidebarLink to="/librarians/books/create" label="Add Book"
                            :active="isActive('/librarians/books/create')" />
                        <SidebarLink to="/librarians/loans" label="Loans" :active="isActive('/librarians/loans')" />
                        <SidebarLink to="/librarians/categories" label="Categories"
                            :active="isActive('/librarians/categories')" />
                        <SidebarLink to="/librarians/authors" label="Authors"
                            :active="isActive('/librarians/authors')" />
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
                    <SidebarLink to="/dashboard" label="Dashboard" :active="isActive('/dashboard')" />
                    <SidebarLink to="/librarians/books" label="Books" :active="isBooksActive" />
                    <SidebarLink to="/librarians/books/create" label="Add Book"
                        :active="isActive('/librarians/books/create')" />
                    <SidebarLink to="/librarians/loans" label="Loans" :active="isActive('/librarians/loans')" />
                    <SidebarLink to="/librarians/categories" label="Categories"
                        :active="isActive('/librarians/categories')" />
                    <SidebarLink to="/librarians/authors" label="Authors" :active="isActive('/librarians/authors')" />
                </nav>
            </div>
        </aside>

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <header class="flex items-center justify-between px-4 py-2 bg-white border-b">
                <div class="flex items-center">
                    <button class="md:hidden p-1 mr-2 rounded hover:bg-gray-200" @click="mobileOpen = true">
                        <!-- burger icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <Link href="/dashboard" class="text-xl font-bold text-gray-800 hover:text-gray-900">
                    Dashboard
                    </Link>
                </div>
                <slot name="headerActions" />
            </header>
            <main class="flex-1 overflow-y-auto p-6">
                <slot />
            </main>
        </div>
        <BackToTop />
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import Notifications from '@/Pages/Components/Notification.vue';
import BackToTop from '@/Pages/Components/BackToTop.vue';

// Reactive for mobile open/close
const mobileOpen = ref(false);

// Helper component for sidebar links
const SidebarLink = {
    props: ['to', 'label', 'active'],
    template: `
      <Link
        :href="to"
        :class="[
          'block px-3 py-2 rounded hover:bg-gray-200',
          active ? 'bg-gray-200 font-bold text-gray-900' : 'text-gray-700'
        ]"
      >{{ label }}</Link>
    `,
    components: { Link }
};

// Compute current path
const pathname = window.location.pathname;

// Function to test exact match
function isActive(path) {
    return pathname === path;
}

// Special logic for “Books” link:
//  – Active on /librarians/books and any edit sub-route (but not /create)
const isBooksActive = computed(() => {
    return (
        pathname === '/librarians/books' ||
        pathname.startsWith('/librarians/books/') && !pathname.startsWith('/librarians/books/create')
    );
});
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