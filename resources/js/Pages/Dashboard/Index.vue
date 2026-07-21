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

const windowWidth = ref(0)

onMounted(() => {
    windowWidth.value = window.innerWidth
})
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
  
<div class="mb-4 text-sm">
    Width: {{ windowWidth }}
</div>

  <Head title="Dashboard" />

    <MainLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

<ContentLayout>

    <div class="space-y-6">

        <!-- Row 1 -->


<DashboardRow>
<DashboardColumn>
    <HeroSection />
</DashboardColumn>
<DashboardColumn>
    <PendingTasks
        :pending-verifications="pendingVerifications"
        :pending-changes="pendingChanges"
        :pending-photo-changes="pendingPhotoChanges"
        :pending-history-changes="pendingHistoryChanges"
    />
</DashboardColumn>
</DashboardRow>


        <!-- Row 2 -->

<DashboardRow>
<DashboardColumn>
    <MaintenanceSummary
        :maintained-assets="maintainedAssets"
        :unmaintained-assets="unmaintainedAssets"
        :maintenance-coverage="maintenanceCoverage"
    />
</DashboardColumn>
<DashboardColumn>
    <AboutSection />
</DashboardColumn>
</DashboardRow>

        <!-- Row 3 -->
        <RecentActivity
            :activities="recentActivities"
        />

    </div>

</ContentLayout>







    </MainLayout>
</template>
