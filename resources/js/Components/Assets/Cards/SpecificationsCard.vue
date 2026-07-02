<script setup>
import InfoRow from '@/Components/Assets/InfoRow.vue'

defineProps({
    asset: Object,
})
</script>

<template>

<div class="mt-8">

    <h3 class="text-lg font-semibold text-gray-800">
        Specifications
    </h3>

    <div class="mt-4 border rounded-lg overflow-hidden">

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

    </div>

</div>

</template>
