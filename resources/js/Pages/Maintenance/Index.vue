<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import VerificationStatCard from '@/Components/Verification/VerificationStatCard.vue'
import MaintenanceTable from '@/Components/Maintenance/MaintenanceTable.vue'
import AssignScheduleModal from '@/Components/Maintenance/AssignScheduleModal.vue'
import PerformMaintenanceModal from '@/Components/Maintenance/PerformMaintenanceModal.vue'
import { usePage } from '@inertiajs/vue3'
import AssetSearchInput from '@/Components/Assets/AssetSearchInput.vue'

const search = ref('')
const page = usePage()
const user = computed(() => page.props.auth.user)
const selectedAsset = ref(null)
const showScheduleModal = ref(false)
const showPerformModal = ref(false)
const props = defineProps({
    totalAssets: Number,
    neverMaintained: Number,
    dueSoon: Number,
    overdue: Number,
    coverage: Number,
    maintenanceAssets: Array,
})
const activeFilter = ref('all')

const filteredAssets = computed(() => {
    let assets

    switch (activeFilter.value) {
        case 'neverMaintained':
            assets = props.maintenanceAssets.filter(asset => !asset.maintenance_date)
            break

        case 'dueSoon':
            assets = props.maintenanceAssets.filter(asset => {
                if (!asset.next_due_date) return false

                const due = new Date(asset.next_due_date)
                const today = new Date()
                const next30 = new Date()
                next30.setDate(today.getDate() + 30)

                return due >= today && due <= next30
            })
            break

        case 'overdue':
            assets = props.maintenanceAssets.filter(asset => {
                if (!asset.next_due_date) return false
                return new Date(asset.next_due_date) < new Date()
            })
            break

        case 'coverage':
            assets = props.maintenanceAssets.filter(asset => asset.next_due_date !== null)
            break

        default:
            assets = props.maintenanceAssets
    }

    if (!search.value) return assets

    const q = search.value.toLowerCase()

    return assets.filter(asset =>
        (asset.property_number ?? '').toLowerCase().includes(q) ||
        (asset.description ?? '').toLowerCase().includes(q) ||
        (asset.type ?? '').toLowerCase().includes(q) ||
        (asset.assigned_to ?? '').toLowerCase().includes(q) ||
        (asset.location ?? '').toLowerCase().includes(q)
    )
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

            <div class="grid grid-cols-5 gap-2">
            
                <VerificationStatCard
                    title="Total Assets"
                    :value="totalAssets"
                    :active="activeFilter === 'all'"
                    @click="activeFilter = 'all'"
                />

                <VerificationStatCard
                    title="Never Maintained"
                    :value="neverMaintained"
                    :active="activeFilter === 'neverMaintained'"
                    @click="activeFilter = 'neverMaintained'"
                />

<VerificationStatCard
    title="Due Soon"
    :value="dueSoon"
    :active="activeFilter === 'dueSoon'"
    @click="activeFilter = 'dueSoon'"
/>

<VerificationStatCard
    title="Overdue"
    :value="overdue"
    :active="activeFilter === 'overdue'"
    @click="activeFilter = 'overdue'"
/>

<VerificationStatCard
    title="Coverage"
    :value="`${coverage}%`"
    :active="activeFilter === 'coverage'"
    @click="activeFilter = 'coverage'"
/>
            </div>

<AssetSearchInput
    v-model="search"
    placeholder="Search maintenance assets..."
/>

<MaintenanceTable
    :assets="filteredAssets"
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
