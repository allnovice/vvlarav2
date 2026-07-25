<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    logs: Object,
});
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto py-8 px-4">

            <h1 class="text-2xl font-bold mb-6">
                Activity Logs
            </h1>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="p-3 text-left">Date</th>
                            <th class="p-3 text-left">User</th>
                            <th class="p-3 text-left">Module</th>
                            <th class="p-3 text-left">Action</th>
                            <th class="p-3 text-left">Description</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="log in logs.data"
                            :key="log.id"
                            class="border-t"
                        >
                            <td class="p-3">
                                {{ log.created_at }}
                            </td>

                            <td class="p-3">
                                {{ log.user?.name ?? 'System' }}
                            </td>

                            <td class="p-3">
                                {{ log.module }}
                            </td>

                            <td class="p-3">
                                {{ log.action }}
                            </td>

                            <td class="p-3">
                                {{ log.description }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
