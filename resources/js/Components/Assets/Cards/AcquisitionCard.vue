<script setup>
import InfoRow from '@/Components/Assets/InfoRow.vue'
import CardSection from '@/Components/Assets/CardSection.vue'

defineProps({
    asset: Object,
})
</script>

<template>

<CardSection title="Acquisition">

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

</CardSection>

</template>
