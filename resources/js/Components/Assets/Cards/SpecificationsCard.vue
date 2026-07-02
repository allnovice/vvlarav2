<script setup>
import InfoRow from '@/Components/Assets/InfoRow.vue'
import CardSection from '@/Components/Assets/CardSection.vue'
import { ComputerDesktopIcon } from '@heroicons/vue/24/outline'

defineProps({
    asset: Object,
})
</script>

<template>

<CardSection
    title="Specifications"
    :icon="ComputerDesktopIcon"
>

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
