<template>
    <section class="relative h-screen bg-cover bg-center bg-no-repeat"
        :style="{ 'background-image': 'url(/images/henry-be-lc7xcWebECc-unsplash.jpg)' }" data-aos="fade-in">
        <div
            class="absolute inset-0 bg-gray bg-opacity-10 flex flex-col justify-center items-center text-center px-4">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight max-w-3xl"
                data-aos="zoom-in" data-aos-delay="200">
                Your Gateway to Unlimited Knowledge
            </h1>
            <p class="mt-4 text-lg sm:text-xl text-gray-200 max-w-2xl" data-aos="fade-up" data-aos-delay="400">
                Browse, borrow, and enjoy your next great read—anywhere, anytime.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row gap-4">
                <Link href="/dashboard"
                    class="px-6 py-3 bg-indigo-500 text-white font-semibold rounded-full shadow hover:bg-indigo-600 transition"
                    data-aos="fade-right" data-aos-delay="600">
                Login
                </Link>
                <Link href="/register"
                    class="px-6 py-3 bg-white text-indigo-700 font-semibold rounded-full shadow hover:bg-gray-100 transition"
                    data-aos="fade-left" data-aos-delay="600">
                Sign Up Free
                </Link>
            </div>
        </div>
    </section>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>