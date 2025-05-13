<template>
    <div class="min-h-screen flex flex-col bg-gray-100">

        <Notifications class="mt-12 -mr-3" />


        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
                <Link href="/" class="text-2xl font-bold text-indigo-600">MyLibrary</Link>
                <nav class="space-x-4">
                    <Link v-if="user.role === 'customer'" href="/profile" class="text-gray-700 hover:text-indigo-600">
                    My Profile
                    </Link>
                    <span v-if="user.role === 'customer'" class="">•</span>
                    <Link href="/dashboard" class="text-gray-700 hover:text-indigo-600">Dashboard</Link>
                    <span class="">•</span>
                    <Link href="/books" class="text-gray-700 hover:text-indigo-600">Books</Link>
                    <span class="">•</span>

                    <button type="button" @click.prevent="logout" class="text-red-600 hover:text-red-800">
                        Logout
                    </button>
                </nav>
            </div>
        </header>

        <!-- Main -->
        <main class="flex-grow">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t py-4 mt-10">
            <div class="max-w-7xl mx-auto px-4 text-center text-gray-600 text-sm">
                © {{ new Date().getFullYear() }} MyLibrary. All rights reserved.
            </div>
        </footer>
        <BackToTop />
    </div>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia';
import { usePage, Link } from '@inertiajs/inertia-vue3';
import Notifications from '@/Pages/Components/Notification.vue';
import BackToTop from '@/Pages/Components/BackToTop.vue';

const page = usePage()
const user = page.props.value.auth.user

function logout() {
    Inertia.post('/logout');
}
</script>