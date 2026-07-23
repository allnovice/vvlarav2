<script setup>
import DashboardWidget from './DashboardWidget.vue'

defineProps({
    maintainedAssets: Number,
    unmaintainedAssets: Number,
    maintenanceCoverage: Number,
})
</script>

<template>
<DashboardWidget>
    
        <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">
          Preventive Maintenance
        </h2>

        <div class="space-y-2">
            <div class="flex justify-between border-t border-gray-200 dark:border-gray-700 pt-2">
                <span class="text-gray-600 dark:text-gray-400">Maintained</span>
                <span class="font-semibold text-gray-900 dark:text-gray-100">{{ maintainedAssets }}</span>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Not Maintained</span>
                <span class="font-semibold text-gray-900 dark:text-gray-100">{{ unmaintainedAssets }}</span>
            </div>

            <div class="flex justify-between border-t pt-2">
                <span class="text-gray-600 dark:text-gray-400">Coverage</span>
                <span class="font-semibold text-gray-900 dark:text-gray-100">
                    {{ maintenanceCoverage }}%
                </span>
            </div>

        </div>
    
</DashboardWidget>
</template>
