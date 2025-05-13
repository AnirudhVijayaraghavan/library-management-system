<template>
    <AuthenticatedLayout>

        <Head title="My Profile" />

        <div class="max-w-2xl mx-auto space-y-8 py-12">

            <!-- 1) Update Name & Email -->
            <section class="bg-white p-6 rounded shadow">
                <h2 class="text-xl font-semibold mb-4">Account Info</h2>
                <form @submit.prevent="updateProfile" class="space-y-4">
                    <div>
                        <label class="block font-medium">Name</label>
                        <input v-model="profileForm.name" type="text" class="w-full border rounded p-2" />
                        <p v-if="profileForm.errors.name" class="text-red-600 text-sm">{{ profileForm.errors.name }}</p>
                    </div>

                    <div>
                        <label class="block font-medium">Email</label>
                        <input v-model="profileForm.email" type="email" class="w-full border rounded p-2" />
                        <p v-if="profileForm.errors.email" class="text-red-600 text-sm">{{ profileForm.errors.email }}
                        </p>
                    </div>

                    <button type="submit" :disabled="profileForm.processing"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                        Save
                    </button>
                </form>
            </section>

            <!-- 2) Update Password -->
            <section class="bg-white p-6 rounded shadow">
                <h2 class="text-xl font-semibold mb-4">Change Password</h2>
                <form @submit.prevent="updatePassword" class="space-y-4">
                    <div>
                        <label class="block font-medium">Current Password</label>
                        <input v-model="passwordForm.current_password" type="password"
                            class="w-full border rounded p-2" />
                        <p v-if="passwordForm.errors.current_password" class="text-red-600 text-sm">{{
                            passwordForm.errors.current_password }}</p>
                    </div>

                    <div>
                        <label class="block font-medium">New Password</label>
                        <input v-model="passwordForm.password" type="password" class="w-full border rounded p-2" />
                        <p v-if="passwordForm.errors.password" class="text-red-600 text-sm">{{
                            passwordForm.errors.password }}</p>
                    </div>

                    <div>
                        <label class="block font-medium">Confirm New Password</label>
                        <input v-model="passwordForm.password_confirmation" type="password"
                            class="w-full border rounded p-2" />
                    </div>

                    <button type="submit" :disabled="passwordForm.processing"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                        Change Password
                    </button>
                </form>
            </section>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, useForm, usePage } from '@inertiajs/inertia-vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

// grab the current user off of page.props.value.auth
const page = usePage()
const user = page.props.value.auth.user

// 1) Profile form (name + email)
const profileForm = useForm({
    name: user.name,
    email: user.email,
})

// 2) Password form
const passwordForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})

function updateProfile() {
    profileForm.put('/profile', {  // or route('profile.update') if you have Ziggy set up
        preserveScroll: true,
    })
}

function updatePassword() {
    passwordForm.put('/profile/password', { // or route('profile.password')
        preserveScroll: true,
    })
}
</script>
