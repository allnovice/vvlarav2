<script setup>
import { ref, computed } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import VerificationStatCard from '@/Components/Verification/VerificationStatCard.vue'
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
    <MainLayout>
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                Verification Dashboard
            </h1>
<div class="mt-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

<VerificationStatCard
    title="Total Assets"
    :value="totalAssets"
    :active="activeFilter === 'all'"
    @click="activeFilter = 'all'"
/>
<VerificationStatCard
    title="Never Verified"
    :value="neverVerified"
    :active="activeFilter === 'neverVerified'"
    @click="activeFilter = 'neverVerified'"
/>
<VerificationStatCard
    title="Due for Verification"
    :value="dueAssets"
    :active="activeFilter === 'due'"
    @click="activeFilter = 'due'"
/>
<VerificationStatCard
    title="Overdue"
    :value="overdueAssets"
    :active="activeFilter === 'overdue'"
    @click="activeFilter = 'overdue'"
/>
<VerificationStatCard
    title="Coverage"
    :value="coverage + '%'"
/>
<VerificationTrendChart
    :data="monthlyVerifications"
    :active="activeFilter === 'verified'"
    @click="activeFilter = 'verified'"
/>
<DueSoonTable
    :assets="filteredAssets"
/>
</div>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                Coming soon...
            </p>
        </div>
    </MainLayout>
</template>
