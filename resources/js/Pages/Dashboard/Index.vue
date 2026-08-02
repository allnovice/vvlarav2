<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { Head } from '@inertiajs/vue3';
import HeroSection from '@/Components/Dashboard/HeroSection.vue'
import AboutSection from '@/Components/Dashboard/AboutSection.vue'
import MaintenanceSummary from '@/Components/Dashboard/MaintenanceSummary.vue'
import PendingTasks from '@/Components/Dashboard/PendingTasks.vue'
import RecentActivity from '@/Components/Dashboard/RecentActivity.vue'
import ContentLayout from '@/Layouts/ContentLayout.vue'
import DashboardRow from '@/Components/Dashboard/DashboardRow.vue'
import DashboardColumn from '@/Components/Dashboard/DashboardColumn.vue'
import { ref, onMounted } from 'vue'
import MaintenanceOverview from '@/Components/Maintenance/MaintenanceOverview.vue'

const windowWidth = ref(0)


defineProps({
    totalAssets: Number,
    activeAssets: Number,
    underRepairAssets: Number,
    borrowedAssets: Number,
    archivedAssets: Number,
    totalUsers: Number,

    pendingChanges: Number,
    pendingVerifications: Number,
    pendingUserApprovals: Number,

maintainedAssets: Number,
unmaintainedAssets: Number,
maintenanceCoverage: Number,

assets: Array,

pendingChanges: Number,
pendingVerifications: Number,
pendingPhotoChanges: Number,
pendingHistoryChanges: Number,
recentActivities: Array,
})

</script>
<template>
    <Head title="Dashboard" />

    <MainLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100">
                Dashboard
            </h2>
        </template>

        <ContentLayout>
            <MaintenanceOverview
                :assets="assets"
            />
        </ContentLayout>
<RecentActivity
            :activities="recentActivities"
        />
    </MainLayout>
</template>
