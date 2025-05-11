<!-- resources/js/Pages/Components/FeaturesSection.vue -->
<template>
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900">Powerful Features</h2>
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                Everything you need to run your library digitally.
            </p>
        </div>
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <FeatureCard icon="📚" title="Extensive Catalog"
                description="Browse and filter thousands of titles with ease." />
            <FeatureCard icon="⏱️" title="Flexible Lending"
                description="Keep books for up to 14 days with easy renewals." />
            <FeatureCard icon="💬" title="Community Reviews"
                description="Read and leave reviews to help fellow readers choose." />
        </div>
    </section>
</template>

<script setup>
import FeatureCard from '@/Pages/Components/FeatureCard.vue';
</script>