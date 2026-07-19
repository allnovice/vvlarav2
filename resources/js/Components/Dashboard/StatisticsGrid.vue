<script setup>
import DashboardStatCard from '@/Components/Dashboard/DashboardStatCard.vue'

defineProps({
    totalAssets: Number,
    activeAssets: Number,
    underRepairAssets: Number,
    borrowedAssets: Number,
    archivedAssets: Number,
    totalUsers: Number,
})
</script>

<template>

<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
    <DashboardStatCard
        title="Total Assets"
        :value="totalAssets"
    />

    <DashboardStatCard
        title="Active Assets"
        :value="activeAssets"
    />

    <DashboardStatCard
        title="Under Repair"
        :value="underRepairAssets"
    />

    <DashboardStatCard
        title="Borrowed"
        :value="borrowedAssets"
    />

    <DashboardStatCard
        title="Archived"
        :value="archivedAssets"
    />

    <DashboardStatCard
        title="Total Users"
        :value="totalUsers"
    />
</div>
</template>
