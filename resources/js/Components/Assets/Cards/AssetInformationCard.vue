<script setup>
import InfoRow from '@/Components/Assets/InfoRow.vue'
import StatusBadge from '@/Components/Assets/StatusBadge.vue'

defineProps({
    asset: Object,
})
</script>

<template>

<div>

    <h3 class="text-lg font-semibold text-gray-800">
        Asset Information
    </h3>

    <div class="mt-4 border rounded-lg overflow-hidden">

        <InfoRow
            label="Property Number"
            :value="asset.property_number"
        />

        <InfoRow
            label="Type"
            :value="asset.type"
        />

        <InfoRow label="Status">

            <StatusBadge :status="asset.status" />

        </InfoRow>

        <InfoRow
            label="Description"
            :value="asset.description"
        />

    </div>

</div>

</template>
