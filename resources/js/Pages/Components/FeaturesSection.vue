<template>
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900">Powerful Features</h2>
            <p class="mt-4 text-gray-600">Everything you need to run your library digitally.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto px-4">
            <FeatureCard icon="📚" title="Easy Catalog" description="Manage your book collection effortlessly." />
            <FeatureCard icon="🔄" title="Borrow & Return" description="Track loans and due dates automatically." />
            <FeatureCard icon="👥" title="Members" description="Handle user roles and profiles with ease." />
        </div>
    </section>
</template>

<script setup>
import FeatureCard from '@/Pages/Components/FeatureCard.vue';
</script>