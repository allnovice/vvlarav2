<script setup>
import { router, usePage } from '@inertiajs/vue3'
import { ref } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import StatusBadge from '@/Components/StatusBadge.vue'
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import ImageModal from '@/Components/ImageModal.vue'

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

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Property Number</p>
            <p class="text-gray-900 dark:text-gray-100">{{ change.data.property_number }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Type</p>
            <p class="text-gray-900 dark:text-gray-100">{{ change.data.type }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Brand</p>
            <p class="text-gray-900 dark:text-gray-100">{{ change.data.brand }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Model</p>
            <p class="text-gray-900 dark:text-gray-100">{{ change.data.model }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Serial Number</p>
            <p class="text-gray-900 dark:text-gray-100">{{ change.data.serial_number }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Assigned To</p>
            <p class="text-gray-900 dark:text-gray-100">{{ change.data.assigned_to }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Department</p>
            <p class="text-gray-900 dark:text-gray-100">{{ change.data.department }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Location</p>
            <p class="text-gray-900 dark:text-gray-100">{{ change.data.location }}</p>
        </div>

        <div class="md:col-span-2">
            <p class="text-sm text-gray-500 dark:text-gray-400">Description</p>
            <p class="text-gray-900 dark:text-gray-100">{{ change.data.description }}</p>
        </div>


<ImageModal
    
    :src="change.data.photo_path ? `/storage/${change.data.photo_path}` : null"
    alt="Asset Photo"
    thumbnail-class="w-32 h-32 rounded-xl object-cover shadow-sm border"
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
