<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'
import { Head } from '@inertiajs/vue3';
import RecentActivity from '@/Components/Dashboard/RecentActivity.vue'
import { ref } from 'vue'
import Changelog from '@/Components/Dashboard/Changelog.vue'


const windowWidth = ref(0)


defineProps({
    recentActivities: Array,
    releases: Array,
})

</script>
<template>
    <Head title="Dashboard" />

    <MainLayout title="Dashboard">


        <RecentActivity
            :activities="recentActivities"
        />

        <Changelog
            :releases="releases"
        />

        
    </MainLayout>
</template>
