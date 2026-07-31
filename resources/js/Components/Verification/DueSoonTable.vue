<script setup>
defineProps({
    assets: {
        type: Array,
        default: () => [],
    },
})
</script>

<template>
    <div class="rounded-xl bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold">
                Upcoming Verifications
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-4 py-3 text-left">Property No.</th>
                        <th class="px-4 py-3 text-left">Type</th>
                        <th class="px-4 py-3 text-left">Brand</th>
                        <th class="px-4 py-3 text-left">Model</th>
                        <th class="px-4 py-3 text-left">Due Date</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="asset in assets"
                        :key="asset.id"
                        class="border-b border-gray-100 dark:border-gray-700"
                    >
                        <td class="px-4 py-3">{{ asset.property_number }}</td>
                        <td class="px-4 py-3">{{ asset.type }}</td>
                        <td class="px-4 py-3">{{ asset.brand }}</td>
                        <td class="px-4 py-3">{{ asset.model }}</td>
                        <td class="px-4 py-3">{{ asset.next_verification_due }}</td>
                    </tr>

                    <tr v-if="assets.length === 0">
                        <td
                            colspan="5"
                            class="px-4 py-6 text-center text-gray-500"
                        >
                            No upcoming verifications.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
