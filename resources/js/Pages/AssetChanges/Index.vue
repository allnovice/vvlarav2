<script setup>
import { router } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'

defineProps({
    changes: Array,
    status: String,
});

function approve(id) {
    router.post(route('asset-changes.approve', id))
}
function filterStatus(event) {
    router.get(route('asset-changes.index'), {
        status: event.target.value,
    })
}
</script>
<template>


<MainLayout>

    <template #header>
        <div class="flex items-center justify-between">

            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                Asset Requests
            </h2>

            <select
                :value="status"
                @change="filterStatus"
                class="rounded-md border-gray-300 bg-white text-sm text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
            >
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
                <option value="all">All</option>
            </select>

        </div>
    </template>


<div class="p-6">

    <div class="overflow-hidden rounded-lg bg-white shadow dark:bg-gray-800">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                <thead class="bg-gray-50 dark:bg-gray-900">

                    <tr>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Property #
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Type
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Requested By
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Action
                        </th>

                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Status
                        </th>

                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            View
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-700 dark:bg-gray-800">

                    <tr
                        v-for="change in changes"
                        :key="change.id"
                        class="transition hover:bg-gray-50 dark:hover:bg-gray-700"
                    >

                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">
                            {{ change.data.property_number }}
                        </td>

                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                            {{ change.data.type }}
                        </td>

                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                            {{ change.user.name }}
                        </td>

                        <td class="px-6 py-4 capitalize">
                            {{ change.action }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            {{ change.status }}
                        </td>

                        <td class="px-6 py-4 text-center">

                            <button
                                @click="router.get(route('asset-changes.show', change.id))"
                                class="text-indigo-600 hover:underline dark:text-indigo-400"
                            >
                                View
                            </button>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>




    


</MainLayout>
</template>
