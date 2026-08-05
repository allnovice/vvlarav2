<script setup>
import { ref, computed } from 'vue'
import StatCard from '@/Components/Operations/Shared/StatCard.vue'
import VerificationTrendChart from '@/Components/Verification/VerificationTrendChart.vue'
import DueSoonTable from '@/Components/Verification/DueSoonTable.vue'

const activeFilter = ref('all')
const filteredAssets = computed(() => {
    const today = new Date()
    today.setHours(0, 0, 0, 0)

    const next30 = new Date(today)
    next30.setDate(next30.getDate() + 30)

    switch (activeFilter.value) {

        case 'overdue':
            return props.verificationAssets.filter(asset => {
                const due = new Date(asset.next_verification_due)
                due.setHours(0, 0, 0, 0)
                return due < today
            })

        case 'due':
            return props.verificationAssets.filter(asset => {
                const due = new Date(asset.next_verification_due)
                due.setHours(0, 0, 0, 0)
                return due >= today && due <= next30
            })

        case 'verified':
            return props.verificationAssets.filter(asset => {
                const due = new Date(asset.next_verification_due)
                due.setHours(0, 0, 0, 0)
                return due > next30
            })

        case 'neverVerified':
            return props.verificationAssets.filter(asset =>
                asset.last_verified_at === null
            )

        default:
            return props.verificationAssets
    }
})
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
        <div class="p-6 space-y-2">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                Verification Dashboard
            </h1>

<div class="grid grid-cols-5 gap-2">
<StatCard
    title="Total Assets"
    :value="totalAssets"
    :active="activeFilter === 'all'"
    @click="activeFilter = 'all'"
/>
<StatCard
    title="Never Verified"
    :value="neverVerified"
    :active="activeFilter === 'neverVerified'"
    @click="activeFilter = 'neverVerified'"
/>
<StatCard
    title="Due for Verification"
    :value="dueAssets"
    :active="activeFilter === 'due'"
    @click="activeFilter = 'due'"
/>
<StatCard
    title="Overdue"
    :value="overdueAssets"
    :active="activeFilter === 'overdue'"
    @click="activeFilter = 'overdue'"
/>
<StatCard
    title="Coverage"
    :value="coverage + '%'"
/>
</div>
<div class="p-6 space-y-2">
<VerificationTrendChart
    :data="monthlyVerifications"
    :active="activeFilter === 'verified'"
    @click="activeFilter = 'verified'"
/>

<DueSoonTable
    :assets="filteredAssets"
/>

</div>
</div>
       
</template>
