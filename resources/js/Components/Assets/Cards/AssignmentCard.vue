<script setup>
import InfoRow from '@/Components/Assets/InfoRow.vue'
import CardSection from '@/Components/Assets/CardSection.vue'

defineProps({
    asset: Object,
})
</script>

<template>

<CardSection title="Assignment">

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

</CardSection>

</template>
