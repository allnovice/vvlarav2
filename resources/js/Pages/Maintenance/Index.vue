<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import MaintenanceTable from '@/Components/Maintenance/MaintenanceTable.vue'
import AssignScheduleModal from '@/Components/Maintenance/AssignScheduleModal.vue'
import PerformMaintenanceModal from '@/Components/Maintenance/PerformMaintenanceModal.vue'
import { usePage } from '@inertiajs/vue3'
import MaintenanceOverview from '@/Components/Maintenance/MaintenanceOverview.vue'

const page = usePage()
const user = computed(() => page.props.auth.user)
const selectedAsset = ref(null)
const showScheduleModal = ref(false)
const showPerformModal = ref(false)
const displayedAssets = ref([])
const props = defineProps({
    maintenanceAssets: Array,
})

const assignSchedule = (asset) => {
    selectedAsset.value = asset
    showScheduleModal.value = true
}

const performMaintenance = (asset) => {
    selectedAsset.value = asset
    showPerformModal.value = true
}
</script>

<template>
    <MainLayout title="Maintenance">
        
        <div class="p-6 space-y-2">
            <h1 class="mt-1 text-2xl font-bold">
                Maintenance
            </h1>

<MaintenanceOverview
    :assets="maintenanceAssets"
@update:filteredAssets="displayedAssets = $event"
/>

<MaintenanceTable
    
    :assets="displayedAssets"
    @assign-schedule="assignSchedule"
    @perform="performMaintenance"
    :can-perform="user?.role === 'technician'"
/>

        </div>

<AssignScheduleModal
    :show="showScheduleModal"
    :asset="selectedAsset"
    @close="showScheduleModal = false"
/>
<PerformMaintenanceModal
    :show="showPerformModal"
    :asset="selectedAsset"
    @close="showPerformModal = false"
/>
    </MainLayout>
</template>
