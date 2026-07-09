<script setup>
import { Link } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'

defineProps({
    users: Object,
})
</script>

<template>
<MainLayout>

        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold">
                    Users
                </h2>

                <div class="text-sm text-gray-500">
                    {{ users.total }} users
                </div>
            </div>
        </template>







    <div class="p-6">
       




<div class="rounded-lg bg-white shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">

            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Name
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Email
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Department
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Position
                    </th>

                    <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Role
                    </th>

                    <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
                        Status
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">

                <tr
                    v-for="user in users.data"
                    :key="user.id"
                    class="hover:bg-gray-50 transition"
                >
                    <td class="px-6 py-4 font-medium">
                        <Link
                            :href="route('users.show', user.id)"
                            class="text-indigo-600 hover:underline"
                        >
                            {{ user.name }}
                        </Link>
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ user.email }}
                    </td>

                    <td class="px-6 py-4">
                        {{ user.department || '-' }}
                    </td>

                    <td class="px-6 py-4">
                        {{ user.position || '-' }}
                    </td>

                    <td class="px-6 py-4 text-center">
                        <span
                            class="rounded-full bg-indigo-100 px-3 py-1 text-xs font-medium text-indigo-700 capitalize"
                        >
                            {{ user.role === 'it_head' ? 'I.T. Head' : user.role.replaceAll('_', ' ') }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-center">
                        <span
                            :class="user.is_active
                                ? 'bg-green-100 text-green-700'
                                : 'bg-red-100 text-red-700'"
                            class="rounded-full px-3 py-1 text-xs font-medium"
                        >
                            {{ user.is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>

                </tr>

            </tbody>

        </table>
    </div>
</div>


    </div>
</MainLayout>
</template>
