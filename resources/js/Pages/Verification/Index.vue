<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import VerificationStatCard from '@/Components/Verification/VerificationStatCard.vue'
import VerificationTrendChart from '@/Components/Verification/VerificationTrendChart.vue'
import DueSoonTable from '@/Components/Verification/DueSoonTable.vue'

const props = defineProps({
    totalAssets: Number,
    dueAssets: Number,
    overdueAssets: Number,
    coverage: Number,
    monthlyVerifications: Array,
    dueSoonAssets: Array,
})
</script>

<template>
    <MainLayout>
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                Verification Dashboard
            </h1>
<div class="mt-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

<VerificationStatCard
    title="Total Assets"
    :value="totalAssets"
    color="blue"
/>
<VerificationStatCard
    title="Due for Verification"
    :value="dueAssets"
    color="yellow"
/>
<VerificationStatCard
    title="Overdue"
    :value="overdueAssets"
/>
<VerificationStatCard
    title="Coverage"
    :value="coverage + '%'"
/>
<VerificationTrendChart
    :data="monthlyVerifications"
/>
<DueSoonTable
    :assets="dueSoonAssets"
/>
</div>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                Coming soon...
            </p>
        </div>
    </MainLayout>
</template>
