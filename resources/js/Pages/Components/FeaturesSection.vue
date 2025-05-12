<template>
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-extrabold text-gray-900">Powerful Features</h2>
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                Everything you need to run your library digitally.
            </p>
        </div>
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <div v-for="(f, i) in features" :key="i" data-aos="zoom-in" :data-aos-delay="200 + i * 200">
                <FeatureCard :icon="f.icon" :title="f.title" :description="f.description" />
            </div>
        </div>
    </section>
</template>

<script setup>
import FeatureCard from '@/Pages/Components/FeatureCard.vue';

const features = [
    { icon: '📚', title: 'Extensive Catalog', description: 'Browse thousands of titles with ease.' },
    { icon: '⏱️', title: 'Flexible Lending', description: 'Keep books 14 days, renew easily.' },
    { icon: '💬', title: 'Community Reviews', description: 'Read and leave ratings & comments.' },
];
</script>