<template>
    <GuestLayout>

        <Head title="Register" />

        <form @submit.prevent="submit" class="space-y-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input v-model="form.name" id="name" type="text" required autofocus
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input v-model="form.email" id="email" type="email" required
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

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                    Password</label>
                <input v-model="form.password_confirmation" id="password_confirmation" type="password" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
            </div>

            <!-- Submit -->
            <div>
                <button type="submit" :disabled="form.processing"
                    class="w-full py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-50">
                    Register
                </button>
            </div>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">
            Already have an account?
            <Link href="/login" class="text-indigo-600 hover:text-indigo-900">Log in</Link>
        </p>
    </GuestLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import GuestLayout from '@/Layouts/Guest.vue'

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

function submit() {
    form.post('/register');
}
</script>