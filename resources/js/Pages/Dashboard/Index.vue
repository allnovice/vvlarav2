<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { Head } from '@inertiajs/vue3'
import RecentActivity from '@/Components/Dashboard/RecentActivity.vue'
import Changelog from '@/Components/Dashboard/Changelog.vue'
import StatCard from '@/Components/Dashboard/StatCard.vue'

defineProps({
    totalAssets: {
        type: Number,
        default: 0,
    },
    assetStatuses: {
        type: Array,
        default: () => [],
    },
    recentActivities: {
        type: Array,
        default: () => [],
    },
    releases: {
        type: Array,
        default: () => [],
    },
})
</script>

<template>
    <Head title="Dashboard" />

        <MainLayout title="Dashboard">
            <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

                <!-- Statistics -->
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

                    <StatCard
                        title="Total Assets"
                        :value="totalAssets"
                        description="All registered assets"
                    />

                    <div
                        class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm
                            dark:border-gray-700 dark:bg-gray-800"
                    >
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Asset Status
                        </div>

                        <div class="mt-4 space-y-3">

                            <div
                                v-for="status in assetStatuses"
                                :key="status.status"
                                class="flex items-center justify-between"
                            >
                                <span class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ status.status }}
                                </span>

                                <span class="font-semibold text-gray-900 dark:text-gray-100">
                                    {{ status.count }}
                                </span>
                            </div>

                        </div>
                    </div>

                </div>

                <!-- Dashboard Content -->
                <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">

                    <section
                        class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm
                            dark:border-gray-700 dark:bg-gray-800"
                    >
                        <RecentActivity
                            :activities="recentActivities"
                        />
                    </section>

                    <section
                        class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm
                            dark:border-gray-700 dark:bg-gray-800"
                    >
                        <Changelog
                            :releases="releases"
                        />
                    </section>

                </div>

            </div>
        </MainLayout>
</template>