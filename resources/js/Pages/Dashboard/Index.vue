<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { Head } from '@inertiajs/vue3';
import RecentActivity from '@/Components/Dashboard/RecentActivity.vue'
import { ref } from 'vue'

const windowWidth = ref(0)


defineProps({
    totalAssets: Number,
    activeAssets: Number,
    underRepairAssets: Number,
    borrowedAssets: Number,
    archivedAssets: Number,
    totalUsers: Number,



maintainedAssets: Number,
unmaintainedAssets: Number,
maintenanceCoverage: Number,

assets: Array,


recentActivities: Array,
})

</script>
<template>
    <Head title="Dashboard" />

    <MainLayout title="Dashboard">


<RecentActivity
            :activities="recentActivities"
        />
    </MainLayout>
</template>
