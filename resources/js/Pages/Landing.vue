<template>
    <div>
        <Notifications class="mt-12 -mr-3 z-10" />
        <HeroSection />
        <FeaturesSection />
        <footer class="bg-white py-6 mt-16">
            <div class="max-w-7xl mx-auto px-4 text-center text-gray-600">
                © {{ new Date().getFullYear() }} MyLibrary. All rights reserved.
            </div>
        </footer>
    </div>
</template>

<script setup>
import HeroSection from '@/Pages/Components/HeroSection.vue'
import FeaturesSection from '@/Pages/Components/FeaturesSection.vue'
import Notifications from '@/Pages/Components/Notification.vue';
</script>
