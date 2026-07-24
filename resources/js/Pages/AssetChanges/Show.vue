<script setup>
import { router, usePage } from '@inertiajs/vue3'
import { ref } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import StatusBadge from '@/Components/StatusBadge.vue'
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import ImageModal from '@/Components/ImageModal.vue'
import DiffField from './Components/DiffField.vue'
import DiffPhoto from './Components/DiffPhoto.vue'

const showApproveModal = ref(false)
const showRejectModal = ref(false)
const page = usePage()
defineProps({
    change: Object,
})
function approve(id) {
    showApproveModal.value = false
    router.post(route('asset-changes.approve', id))
}
function reject(id) {
    showRejectModal.value = false
    router.post(route('asset-changes.reject', id))
}
function formatDate(date) {
    return new Date(date).toLocaleString()
}
function back() {
    router.visit(route('asset-changes.index'))
}
</script>

<template>
<MainLayout>
<template #header>
    <div class="flex items-center gap-4">
        <button
            @click="back"
            
            class="rounded border border-gray-300 px-3 py-1 text-sm hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700"
        >
            ← Back
        </button>

        
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100">
            Asset Request
        </h2>
    </div>
</template>



<div
    v-if="page.props.errors.change"
    class="mb-4 rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700 dark:border-red-700 dark:bg-red-900/40 dark:text-red-300"
    
>
    {{ page.props.errors.change }}
</div>


<div class="py-6 px-6">

        <div class="rounded-lg bg-white p-6 shadow dark:bg-gray-800">

    
    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">
        Asset Request
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Requested By</p>
            <p class="text-gray-900 dark:text-gray-100">{{ change.user.name }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Action</p>
            <p class="capitalize text-gray-900 dark:text-gray-100">{{ change.action }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>


<StatusBadge :status="change.status" />



        </div>

    </div>

</div>



<div class="rounded-lg bg-white p-6 shadow dark:bg-gray-800">

    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">
        Asset Information
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">







<DiffField
    label="Property Number"
    :old-value="change.asset?.property_number"
    :new-value="change.data.property_number"
/>
<DiffField
    label="Type"
    :old-value="change.asset?.type"
    :new-value="change.data.type"
/>
<DiffField
    label="Status"
    :old-value="change.asset?.status"
    :new-value="change.data.status"
/>
<DiffField
    label="Brand"
    :old-value="change.asset?.brand"
    :new-value="change.data.brand"
/>
<DiffField
    label="Brand"
    :old-value="change.asset?.brand"
    :new-value="change.data.brand"
/>
<DiffField
    label="Model"
    :old-value="change.asset?.model"
    :new-value="change.data.model"
/>
<DiffField
    label="Serial Number"
    :old-value="change.asset?.serial_number"
    :new-value="change.data.serial_number"
/>
<DiffField
    label="Assigned to"
    :old-value="change.asset?.assigned_to"
    :new-value="change.data.assigned_to"
/>
<DiffField
    label="Department"
    :old-value="change.asset?.department"
    :new-value="change.data.department"
/>
<DiffField
    label="Location"
    :old-value="change.asset?.location"
    :new-value="change.data.location"
/>
<DiffField
    label="Description"
    :old-value="change.asset?.description"
    :new-value="change.data.description"
/>
<DiffPhoto
    :old-photo="change.asset?.photo_path"
    :new-photo="change.data.photo_path"
/>







    </div>

</div>





<div
    v-if="change.status !== 'pending'"
    class="rounded-lg bg-white p-6 shadow dark:bg-gray-800"
>

    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">
        Processing
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Processed By</p>
            <p class="text-gray-900 dark:text-gray-100">{{ change.approver?.name }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Processed At</p>
            <p class="text-gray-900 dark:text-gray-100">{{ formatDate(change.approved_at) }}</p>
        </div>

    </div>

</div>






<div
    v-if="change.status === 'pending'"
    class="rounded-lg bg-white p-6 shadow dark:bg-gray-800"
>


    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">
        Actions
    </h3>

    <div class="flex gap-4">


<button
    @click="showApproveModal = true"
    class="px-6 py-2 rounded bg-green-600 text-white hover:bg-green-700 transition"
>
    ✓ Approve
</button>
<button
    @click="showRejectModal = true"
    class="rounded bg-red-600 px-6 py-2 text-white transition hover:bg-red-700"
>
    ✕ Reject
</button>


    </div>

</div>



</div>
</MainLayout>
<ConfirmationModal
    :show="showApproveModal"
    title="Approve Asset Change"
    message="Are you sure you want to approve this asset change?"
    confirm-text="Approve"
    @close="showApproveModal = false"
    @confirm="approve(change.id)"
/>
<ConfirmationModal
    :show="showRejectModal"
    title="Reject Asset Change"
    message="Are you sure you want to reject this asset change?"
    confirm-text="Reject"
    @close="showRejectModal = false"
    @confirm="reject(change.id)"
/>

</template>
