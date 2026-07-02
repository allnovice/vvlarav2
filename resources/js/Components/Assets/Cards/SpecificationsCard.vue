<script setup>
import InfoRow from '@/Components/Assets/InfoRow.vue'
import CardSection from '@/Components/Assets/CardSection.vue'

defineProps({
    asset: Object,
})
</script>

<template>

<CardSection title="Specifications">

    <InfoRow
        label="Brand"
        :value="asset.brand"
    />

    <InfoRow
        label="Model"
        :value="asset.model"
    />

    <InfoRow
        label="Serial Number"
        :value="asset.serial_number"
    />

    <InfoRow
        label="Manufacturer"
        :value="asset.manufacturer"
    />

</CardSection>

</template>
