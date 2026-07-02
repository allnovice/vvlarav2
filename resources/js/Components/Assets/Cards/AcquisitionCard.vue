<script setup>
import InfoRow from '@/Components/Assets/InfoRow.vue'

defineProps({
    asset: Object,
})
</script>

<template>

<div class="mt-8">

    <h3 class="text-lg font-semibold text-gray-800">
        Acquisition
    </h3>

    <div class="mt-4 border rounded-lg overflow-hidden">

        <InfoRow
            label="Acquisition Date"
            :value="asset.acquisition_date"
            type="date"
        />

        <InfoRow
            label="Acquisition Cost"
            :value="asset.acquisition_cost"
            type="currency"
        />

        <InfoRow
            label="Supplier"
            :value="asset.supplier"
        />

        <InfoRow
            label="Warranty Expiry"
            :value="asset.warranty_expiry"
            type="date"
        />

    </div>

</div>

</template>
