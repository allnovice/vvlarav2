<script setup>
import InfoRow from '@/Components/Assets/InfoRow.vue'
import CardSection from '@/Components/Assets/CardSection.vue'
import { UserIcon } from '@heroicons/vue/24/outline'

defineProps({
    asset: Object,
})
</script>

<template>

<CardSection
    title="Assignment"
    :icon="UserIcon"
>

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
