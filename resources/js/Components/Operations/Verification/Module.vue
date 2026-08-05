<script setup>
import Overview from '@/Components/Operations/Verification/Overview.vue'
import ModuleLayout from '@/Components/Operations/Shared/ModuleLayout.vue'

const props = defineProps({
    totalAssets: Number,
    dueAssets: Number,
    overdueAssets: Number,
    coverage: Number,
    monthlyVerifications: Array,
    verificationAssets: Array,
    neverVerified: Number,
})
</script>
<template>

<Overview
    :total-assets="props.totalAssets"
    :due-assets="props.dueAssets"
    :overdue-assets="props.overdueAssets"
    :coverage="props.coverage"
    :monthly-verifications="props.monthlyVerifications"
    :verification-assets="props.verificationAssets"
    :never-verified="props.neverVerified"
/>

</template>
