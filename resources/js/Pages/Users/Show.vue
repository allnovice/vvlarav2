<script setup>
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'

const page = usePage()

const isAdmin = computed(() => page.props.auth.user?.role === 'admin')

const formatRole = (role) => {
    if (role === 'it_head') return 'I.T. Head'
    return role?.replace(/_/g, ' ')
}

defineProps({
    user: Object,
})



</script>

<template>
    <MainLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ user.name }}
                </h2>

<Link
    v-if="isAdmin"
    :href="route('users.edit', user.id)"
    class="rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
>
    Edit User
</Link>


            </div>
        </template>

        <div class="mx-auto max-w-4xl p-6">
            
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Name</p>
                        <p class="text-gray-900 dark:text-gray-100">{{ user.name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-gray-900 dark:text-gray-100">{{ user.email }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Department</p>
                        <p class="text-gray-900 dark:text-gray-100">{{ user.department || '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Position</p>
                        <p class="text-gray-900 dark:text-gray-100">{{ user.position || '-' }}</p>
                    </div>

<div>
    <p class="text-sm text-gray-500 dark:text-gray-400">Role</p>
    <p class="text-gray-900 dark:text-gray-100">
        {{ formatRole(user.role) }}
    </p>
</div>

                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <p class="text-gray-900 dark:text-gray-100">{{ user.is_active ? 'Active' : 'Inactive' }}</p>
                    </div>

                </div>

            </div>
        </div>
    </MainLayout>
</template>
