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
    
        <h2 class="mb-4 text-lg font-semibold text-gray-900">
            Preventive Maintenance
        </h2>

        <div class="space-y-2">
            <div class="flex justify-between">
                <span>Maintained</span>
                <span class="font-semibold">{{ maintainedAssets }}</span>
            </div>

            <div class="flex justify-between">
                <span>Not Maintained</span>
                <span class="font-semibold">{{ unmaintainedAssets }}</span>
            </div>

            <div class="flex justify-between border-t pt-2">
                <span>Coverage</span>
                <span class="font-semibold">
                    {{ maintenanceCoverage }}%
                </span>
            </div>
        </div>
    
</DashboardWidget>
</template>
