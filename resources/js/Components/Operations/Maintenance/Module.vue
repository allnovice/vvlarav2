<script setup>
import { ref } from 'vue'
import MaintenanceOverview from '@/Components/Operations/Maintenance/Overview.vue'
import MaintenanceTable from '@/Components/Operations/Maintenance/Table.vue'
import AssignScheduleModal from '@/Components/Operations/Maintenance/AssignScheduleModal.vue'
import PerformMaintenanceModal from '@/Components/Operations/Maintenance/PerformMaintenanceModal.vue'
import ModuleLayout from '@/Components/Operations/Shared/ModuleLayout.vue'

const displayedAssets = ref([])
const selectedAsset = ref(null)
const showScheduleModal = ref(false)
const showPerformModal = ref(false)
const props = defineProps({
    assets: Array,
    displayedAssets: Array,
    canPerform: Boolean,
})
const emit = defineEmits([
    'update:filteredAssets',
    'assign-schedule',
    'perform',
])
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
<ModuleLayout title="Maintenance">

<MaintenanceOverview
    :assets="props.assets"
    @update:filteredAssets="emit('update:filteredAssets', $event)"
/>

<MaintenanceTable
    :assets="props.displayedAssets"
    :can-perform="props.canPerform"
    @assign-schedule="assignSchedule"
    @perform="performMaintenance"
/>


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



</ModuleLayout>
</template>
