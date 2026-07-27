<script setup>
import { Link } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import { ref } from 'vue';

defineProps({
    users: Object,
})
</script>

<template>
<MainLayout>

        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    Users
                </h2>

                <div class="text-sm text-gray-500 dark:text-gray-400">
                    {{ users.total }} users
                </div>
            </div>
        </template>







    <div class="p-6">
       



<div class="overflow-hidden rounded-lg bg-white shadow dark:bg-gray-800">

    <div class="overflow-x-auto">
       
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            
            <thead class="bg-gray-50 dark:bg-gray-900">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Name
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Email
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Department
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Position
                    </th>

                    <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Role
                    </th>



<th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
    Status
</th>


                </tr>
            </thead>

            
            <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-700 dark:bg-gray-800">
                <tr
                    v-for="user in users.data"
                    :key="user.id"
                 
                    class="transition hover:bg-gray-50 dark:hover:bg-gray-700"
                >
                    <td class="px-6 py-4 font-medium">
                        <Link
                            :href="route('users.show', user.id)"
                           
                            class="text-indigo-600 hover:underline dark:text-indigo-400"
                        >
                            {{ user.name }}
                        </Link>
                    </td>

                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
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
                            class="rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300 capitalize"
                        >
                            {{ user.role === 'it_head' ? 'I.T. Head' : user.role.replaceAll('_', ' ') }}
                        </span>
                    </td>



                    <td class="px-6 py-4 text-center">
                       
<span
    :class="
        user.is_active
            ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300'
            : 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300'
    "
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
