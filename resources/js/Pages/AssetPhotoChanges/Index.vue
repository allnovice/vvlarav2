<script setup>
import { router } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'

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

        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold">
                    Photo Upload Requests
                </h2>

                <select
                    :value="status"
                    @change="filterStatus"
                    class="rounded-md border-gray-300 text-sm"
                >
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                    <option value="all">All</option>
                </select>
            </div>
        </template>

        <div class="p-6">

            <div class="rounded-lg bg-white shadow overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">

                            <tr>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                                    Asset
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                                    Submitted By
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase">
                                    Preview
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase">
                                    Status
                                </th>

<th class="px-6 py-3 text-center text-xs font-semibold uppercase">
    Action
</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold uppercase">
                                    View
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">

                            









<tr
    v-for="change in changes"
    :key="change.id"
>
    <td class="px-6 py-4">
        {{ change.asset.property_number }}
    </td>

    <td class="px-6 py-4">
        {{ change.user.name }}
    </td>

    <td class="px-6 py-4 text-center">
        <img
            :src="`/storage/${change.photo_path}`"
            class="mx-auto h-16 w-16 rounded object-cover border"
        >
    </td>

    <td class="px-6 py-4 text-center">
        {{ change.status }}
    </td>

    <td class="px-6 py-4 text-center">
        <span class="capitalize">
            {{ change.action }}
        </span>
    </td>

    <td class="px-6 py-4 text-center">
        <button
            @click="router.get(route('asset-photo-changes.show', change.id))"
            class="text-indigo-600 hover:underline"
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
