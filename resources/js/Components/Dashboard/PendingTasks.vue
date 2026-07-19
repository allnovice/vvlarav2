<script setup>
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
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="mb-4 text-lg font-semibold">
            Pending Tasks
        </h2>

        <div class="space-y-3">
            <div class="flex justify-between">
                <span>Pending Verifications</span>
                <span>{{ pendingVerifications }}</span>
            </div>

            <div class="flex justify-between">
                <span>Pending Changes</span>
                <span>{{ pendingChanges }}</span>
            </div>

            <div class="flex justify-between">
                <span>Pending Photo Changes</span>
                <span>{{ pendingPhotoChanges }}</span>
            </div>

<div class="flex justify-between">
    <span>Pending History Changes</span>
    <span>{{ pendingHistoryChanges }}</span>
</div>


        </div>
    </div>
</template>
