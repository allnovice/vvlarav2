<script setup>
import InfoRow from '@/Components/Assets/InfoRow.vue'

defineProps({
    asset: Object,
})
</script>

<template>

<div class="mt-8">

    <h3 class="text-lg font-semibold text-gray-800">
        Assignment
    </h3>

    <div class="mt-4 border rounded-lg overflow-hidden">

        <InfoRow
            label="Department"
            :value="asset.department"
        />

        <InfoRow
            label="Location"
            :value="asset.location"
        />

        <InfoRow
            label="Assigned To"
            :value="asset.assigned_to"
        />

    </div>

</div>

</template>
