<template>
    <GuestLayout>

        <Head title="Login" />
        <div class="max-w-md mx-auto mt-12 px-6">
            <!-- Logo + App Name -->
            <div class="text-center mb-8">
                <img src="/public/icons8-library-16.png" alt="MyLibrary" class="h-12 w-12 mx-auto" />
                <h1 class="mt-2 text-3xl font-extrabold text-gray-900">MyLibrary</h1>
            </div>
            <form @submit.prevent="submit" class="space-y-6">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input v-model="form.email" id="email" type="email" required autofocus
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input v-model="form.password" id="password" type="password" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                    <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input v-model="form.remember" id="remember" type="checkbox"
                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                    <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit" :disabled="form.processing"
                        class="w-full py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-50">
                        Log in
                    </button>
                </div>
            </form>
        </div>
        <p class="mt-4 text-center text-sm text-gray-600">
            Need an account?
            <Link href="/register" class="text-indigo-600 hover:text-indigo-900">Register</Link>
        </p>
    </GuestLayout>
</template>

<script setup>
console.log('🛠️ Login.vue mounted')
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import GuestLayout from '@/Layouts/Guest.vue';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

function submit() {
    form.post('/login');
}
</script>