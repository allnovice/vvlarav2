<script setup>
import { router } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import ImageModal from '@/Components/ImageModal.vue'

defineProps({
    changes: Array,
    status: String,
})

function filterStatus(event) {
    router.get(route('asset-photo-changes.index'), {
        status: event.target.value,
    })
}
</script>

<template>
    <MainLayout>


            <div class="flex items-center justify-end p-4">

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
        <div class="p-6">

            <div class="overflow-hidden rounded-lg bg-white shadow dark:bg-gray-800">

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                        <thead class="bg-gray-50 dark:bg-gray-900">

                            <tr>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                                    Asset
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Submitted By
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Preview
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Status
                                </th>

<th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
    Action
</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
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
    
    <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
        {{ change.asset.property_number }}
    </td>

    <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
        {{ change.user.name }}
    </td>

    <td class="px-6 py-4 text-gray-900 dark:text-gray-100">


<ImageModal
    :src="`/storage/${change.photo_path}`"
    alt="Asset Photo"
    thumbnail-class="mx-auto h-16 w-16 rounded object-cover border"
/>



    </td>

    <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
        {{ change.status }}
    </td>

<td class="px-6 py-4 text-center text-gray-900 dark:text-gray-100">
    <span class="capitalize">
        {{ change.action }}
    </span>
</td>

    <td class="px-6 py-4 text-center">
        <button
            @click="router.get(route('asset-photo-changes.show', change.id))"
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
