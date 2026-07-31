<script setup>
defineProps({
    assets: {
        type: Array,
        default: () => [],
    },
})
const formatDate = (date) => {
    return new Date(date).toLocaleDateString(undefined, {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    })
}
const getDueStatus = (date) => {
    const today = new Date()
    today.setHours(0, 0, 0, 0)

    const due = new Date(date)
    due.setHours(0, 0, 0, 0)

    const days = Math.ceil((due - today) / (1000 * 60 * 60 * 24))

    if (days < 0) {
        return {
            days,
            label: 'Overdue',
            classes: 'bg-red-100 text-red-800',
        }
    }

    if (days <= 7) {
        return {
            days,
            label: `${days} day(s)`,
            classes: 'bg-yellow-100 text-yellow-800',
        }
    }

    return {
        days,
        label: `${days} day(s)`,
        classes: 'bg-green-100 text-green-800',
    }
}
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
                        <th class="px-4 py-3 text-left">Days Remaining</th>
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
                        <td class="px-4 py-3">{{ formatDate(asset.next_verification_due) }}</td>

<td class="px-4 py-3">
    <span
        class="inline-flex rounded-full px-2 py-1 text-xs font-medium"
        :class="getDueStatus(asset.next_verification_due).classes"
    >
        {{ getDueStatus(asset.next_verification_due).label }}
    </span>
</td>

                    </tr>

                    <tr v-if="assets.length === 0">
                        <td
                            colspan="6"
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
