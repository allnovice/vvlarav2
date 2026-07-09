<script setup>
import { router } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'

defineProps({
    verifications: Array,
    status: String,
})

function filterStatus(event) {
    router.get(route('asset-verifications.index'), {
        status: event.target.value,
    })
}
</script>

<template>
<MainLayout>

    <template #header>

        <div class="flex items-center justify-between">

            <h2 class="text-xl font-semibold">
                Verification Requests
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

    <div class="py-6 px-6">

        <div class="rounded-lg bg-white shadow overflow-hidden">

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Asset
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Submitted By
                            </th>

                            <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Status
                            </th>

                            <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">

                        <tr
                            v-for="verification in verifications"
                            :key="verification.id"
                            class="hover:bg-gray-50 transition"
                        >

                            <td class="px-6 py-4 font-medium">
                                {{ verification.asset.property_number }}
                            </td>

                            <td class="px-6 py-4">
                                {{ verification.user.name }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                {{ verification.status }}
                            </td>

                            <td class="px-6 py-4 text-center">

                                <button
                                    @click="router.get(route('asset-verifications.show', verification.id))"
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





















