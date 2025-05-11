<template>
    <div>
        <Notifications class="mt-12 -mr-3 z-10" />

        <HeroSection />

        <FeaturesSection />

        <NewArrivalsSection :books="featuredBooks" />

        <footer class="bg-white py-6 mt-16">
            <div class="max-w-7xl mx-auto px-4 text-center text-gray-600">
                © {{ new Date().getFullYear() }} MyLibrary. All rights reserved.
            </div>
        </footer>
    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/inertia-vue3';
import HeroSection from '@/Pages/Components/HeroSection.vue';
import FeaturesSection from '@/Pages/Components/FeaturesSection.vue';
import NewArrivalsSection from '@/Pages/Components/NewArrivalsSection.vue';
import Notifications from '@/Pages/Components/Notification.vue';

// Pull in the “featuredBooks” prop your controller supplies:
const featuredBooks = usePage().props.value.featuredBooks || [];
</script>