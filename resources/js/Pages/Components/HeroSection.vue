<template>
    <section class="relative h-screen bg-cover bg-center" style="background-image:url('/images/library-hero.jpg')">
        <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center text-center px-4">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight max-w-3xl">
                Your Gateway to Unlimited Knowledge
            </h1>
            <p class="mt-4 text-lg sm:text-xl text-gray-200 max-w-2xl">
                Browse, borrow, and enjoy your next great read—anywhere, anytime.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row gap-4">
                <Link href="/books"
                    class="px-6 py-3 bg-indigo-500 text-white font-semibold rounded-full shadow hover:bg-indigo-600 transition">
                Browse Catalog
                </Link>
                <Link href="/register"
                    class="px-6 py-3 bg-white text-indigo-700 font-semibold rounded-full shadow hover:bg-gray-100 transition">
                Sign Up Free
                </Link>
            </div>
        </div>
    </section>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>