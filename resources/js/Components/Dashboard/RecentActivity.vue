<script setup>
import DashboardWidget from './DashboardWidget.vue'
import { Link } from '@inertiajs/vue3'

defineProps({
    activities: {
        type: Array,
        default: () => [],
    },
})
const formatDate = (value) => {
    return new Date(value).toLocaleString([], {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: 'numeric',
        minute: '2-digit',
    })
}
</script>

<template>
<DashboardWidget>
        <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">
            Recent Activity
        </h2>

        <div
            v-if="activities.length"
            class="space-y-3"
        >

<template
    v-for="activity in activities"
    :key="activity.id"
>
    <Link
        v-if="activity.asset"
        :href="`/assets/${activity.asset.id}`"
        class="block rounded-md border-b border-gray-100 dark:border-gray-700 p-2 pb-3 transition-colors hover:bg-gray-50 dark:hover:bg-gray-700 last:border-b-0"
    >
        <div class="font-medium text-gray-900 dark:text-gray-100">
            {{ activity.title }}
        </div>

        <div class="text-sm text-gray-600 dark:text-gray-400">
            #{{ activity.asset.property_number }}
            •
            {{ activity.asset.type }}
        </div>

        <div class="text-sm text-gray-600 dark:text-gray-400">
            {{ activity.asset.assigned_to }}
            •
            {{ activity.asset.department }}
            -
            {{ activity.asset.location }}
        </div>

        <div class="text-xs text-gray-500 dark:text-gray-500">
            {{ activity.performed_by }}
            •
            {{ formatDate(activity.performed_at) }}
        </div>
    </Link>
</template>



        </div>

<div
    v-else
    class="text-sm text-gray-500 dark:text-gray-400"
>
            No recent activity.
        </div>
</DashboardWidget>
</template>
