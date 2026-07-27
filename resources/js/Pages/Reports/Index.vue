<script setup>
import { router } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue';
import AssetTable from '@/Components/Assets/AssetTable.vue'
import ReportToolbar from '@/Components/Reports/ReportToolbar.vue'

const props = defineProps({
    assets: Object,
    departments: Array,
    locations: Array,
    types: Array,
    statuses: Array,
    filters: Object,
})
const updateFilters = (filters) => {
    router.get(route('reports.index'), filters, {
        preserveState: true,
        replace: true,
    })
}
function exportCsv() {
    const params = new URLSearchParams()

    Object.entries(props.filters).forEach(([key, value]) => {
        if (value) {
            params.append(key, value)
        }
    })

    window.location.href = `/reports/export/csv?${params.toString()}`
}
</script>

<template>
    <MainLayout>
        <div class="p-6">
            <h1 class="text-2xl font-bold">Reports</h1>
<ReportToolbar
    :departments="props.departments"
    :locations="props.locations"
    :types="props.types"
    :statuses="props.statuses"
    :filters="props.filters"
    @update:filters="updateFilters"
    @export="exportCsv"
/>
<AssetTable
    :assets="props.assets.data"
    :sortBy="'property_number'"
    :sortDirection="'asc'"
    :isAuthenticated="false"
/>
            
        </div>
    </MainLayout>
</template>
