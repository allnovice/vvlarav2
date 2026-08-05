<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import { usePage } from '@inertiajs/vue3'
import MaintenanceModule from '@/Components/Operations/Maintenance/Module.vue'
import VerificationModule from '@/Components/Operations/Verification/Module.vue'
import ReportsModule from '@/Components/Operations/Reports/Module.vue'

const page = usePage()
const user = computed(() => page.props.auth.user)
const displayedAssets = ref([])
const mode = ref('maintenance')
const props = defineProps({
    maintenance: Object,
    verification: Object,
})
</script>

<template>
    <MainLayout title="Maintenance">
        
        <div class="p-6 space-y-2">
            <h1 class="mt-1 text-2xl font-bold">
                Operations
            </h1>


<div class="flex gap-2 border-b pb-4">

    <button
        @click="mode = 'maintenance'"
        :class="[
            mode === 'maintenance'
                ? 'bg-indigo-600 text-white'
                : 'bg-gray-200 dark:bg-gray-700',
            'rounded px-4 py-2'
        ]"
    >
        Maintenance
    </button>

<button
    @click="mode = 'verification'"
    :class="[
        mode === 'verification'
            ? 'bg-indigo-600 text-white'
            : 'bg-gray-200 dark:bg-gray-700',
        'rounded px-4 py-2'
    ]"
>
    Verification
</button>



<button
    @click="mode = 'reports'"
    :class="[
        mode === 'reports'
            ? 'bg-indigo-600 text-white'
            : 'bg-gray-200 dark:bg-gray-700',
        'rounded px-4 py-2'
    ]"
>
    Reports
</button>



</div>

<MaintenanceModule
    v-if="mode === 'maintenance'"
    :assets="props.maintenance.assets"
    :displayed-assets="displayedAssets"
    :can-perform="user?.role === 'technician'"
    
    @update:filtered-assets="displayedAssets = $event"
/>
<VerificationModule
    v-else-if="mode === 'verification'"
    :total-assets="props.verification.totalAssets"
    :due-assets="props.verification.dueAssets"
    :overdue-assets="props.verification.overdueAssets"
    :coverage="props.verification.coverage"
    :monthly-verifications="props.verification.monthlyVerifications"
    :verification-assets="props.verification.verificationAssets"
    :never-verified="props.verification.neverVerified"
/>
<ReportsModule
    v-else-if="mode === 'reports'"
/>


</div>
    </MainLayout>
</template>
