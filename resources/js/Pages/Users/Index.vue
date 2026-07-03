<script setup>
import { Link } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'

defineProps({
    users: Object,
})
</script>

<template>
<MainLayout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Users</h1>

<table class="min-w-full border border-gray-200">
    <thead class="bg-gray-100">
        <tr>
            <th class="border p-2 text-left">Name</th>
            <th class="border p-2 text-left">Email</th>
            <th class="border p-2 text-left">Department</th>
            <th class="border p-2 text-left">Position</th>
            <th class="border p-2 text-left">Role</th>
            <th class="border p-2 text-center">Status</th>
            <th class="border p-2 text-center">Actions</th>
        </tr>
    </thead>

    <tbody>
        <tr
            v-for="user in users.data"
            :key="user.id"
        >


<td class="border p-2">
    <Link
        :href="route('users.show', user.id)"
        class="text-blue-600 hover:underline"
    >
        {{ user.name }}
    </Link>
</td>

            <td class="border p-2">{{ user.email }}</td>
            <td class="border p-2">{{ user.department || '-' }}</td>
            <td class="border p-2">{{ user.position || '-' }}</td>
            <td class="border p-2 capitalize">{{ user.role }}</td>

            <td class="border p-2 text-center">
                <span
                    :class="user.is_active
                        ? 'text-green-600'
                        : 'text-red-600'"
                >
                    {{ user.is_active ? 'Active' : 'Inactive' }}
                </span>
            </td>

            <td class="border p-2 text-center">
                Edit
            </td>
        </tr>
    </tbody>
</table>



    </div>
</MainLayout>
</template>
