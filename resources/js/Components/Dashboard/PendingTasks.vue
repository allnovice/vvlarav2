<script setup>
import DashboardWidget from './DashboardWidget.vue'
import { router } from '@inertiajs/vue3'

defineProps({
    pendingVerifications: {
        type: Number,
        default: 0,
    },
    pendingChanges: {
        type: Number,
        default: 0,
    },
    pendingPhotoChanges: {
        type: Number,
        default: 0,
    },
    pendingHistoryChanges: {
        type: Number,
        default: 0,
    },

})
</script>

<template>
<DashboardWidget>
    
        <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">
            Pending Tasks
        </h2>

        <div class="space-y-3">
<div
    @click="router.visit(route('asset-verifications.index'))"
    class="flex cursor-pointer justify-between rounded px-2 py-2 transition hover:bg-gray-100 dark:hover:bg-gray-700"
>
                <span class="text-gray-600 dark:text-gray-400">Pending Verifications</span>
                <span class="font-semibold text-gray-900 dark:text-gray-100">{{ pendingVerifications }}</span>
            </div>

<div
    @click="router.visit(route('asset-changes.index'))"
    class="flex cursor-pointer justify-between rounded px-2 py-2 transition hover:bg-gray-100 dark:hover:bg-gray-700"
>
                <span class="text-gray-600 dark:text-gray-400">Pending Changes</span>
                <span class="font-semibold text-gray-900 dark:text-gray-100">{{ pendingChanges }}</span>
            </div>

<div
    @click="router.visit(route('asset-photo-changes.index'))"
    class="flex cursor-pointer justify-between rounded px-2 py-2 transition hover:bg-gray-100 dark:hover:bg-gray-700"
>
                <span class="text-gray-600 dark:text-gray-400">Pending Photo Changes</span>
                <span class="font-semibold text-gray-900 dark:text-gray-100">{{ pendingPhotoChanges }}</span>
            </div>

<div
    @click="router.visit(route('asset-history-changes.index'))"
    class="flex cursor-pointer justify-between rounded px-2 py-2 transition hover:bg-gray-100 dark:hover:bg-gray-700"
>
    <span class="text-gray-600 dark:text-gray-400">Pending History Changes</span>
    <span class="font-semibold text-gray-900 dark:text-gray-100">{{ pendingHistoryChanges }}</span>
</div>


        </div>
    
</DashboardWidget>
</template>
