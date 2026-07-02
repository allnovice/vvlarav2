<script setup>
import InfoRow from '@/Components/Assets/InfoRow.vue'
import StatusBadge from '@/Components/Assets/StatusBadge.vue'
import CardSection from '@/Components/Assets/CardSection.vue'

defineProps({
    asset: Object,
})
</script>

<template>

<CardSection
    title="Asset Information"
>

    <InfoRow
        label="Property Number"
        :value="asset.property_number"
    />

    <InfoRow
        label="Type"
        :value="asset.type"
    />

    <InfoRow label="Status">

        <StatusBadge
            :status="asset.status"
        />

    </InfoRow>

    <InfoRow
        label="Description"
        :value="asset.description"
    />

</CardSection>
       
</template>
