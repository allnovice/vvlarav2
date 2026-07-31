<script setup>
import { router, usePage } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import StatusBadge from '@/Components/StatusBadge.vue'
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import { ref } from 'vue';

defineProps({
    change: Object,
})
const showApproveModal = ref(false);
const showRejectModal = ref(false);
const page = usePage()
function back() {
    router.visit(route('asset-history-changes.index'))
}
function approve(id) {
    showApproveModal.value = false
    router.post(route('asset-history-changes.approve', id))
}

function reject(id) {
    showRejectModal.value = false
    router.post(route('asset-history-changes.reject', id))
}


function formatDate(date) {
    return new Date(date).toLocaleString()
}
function formatShortDate(date) {
    return new Date(date).toLocaleDateString()
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
            History Change Request
        </h2>

    </div>
</template>



    <div class="py-6 px-6">


<div
    v-if="page.props.errors.change"
    class="mb-4 rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700 dark:border-red-700 dark:bg-red-900/40 dark:text-red-300"
>
    {{ page.props.errors.change }}
</div>   


<div class="rounded-lg bg-white p-6 shadow dark:bg-gray-800 mb-6">

    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">
        History Change Request
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Requested By</p>
            <p class="text-gray-900 dark:text-gray-100">{{ change.user.name }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Asset</p>
            <p class="text-gray-900 dark:text-gray-100">{{ change.asset.property_number }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>


<StatusBadge :status="change.status" />


        </div>

    </div>

</div>


<div
    v-if="change.status !== 'pending'"
    class="rounded-lg bg-white p-6 shadow dark:bg-gray-800 mb-6"
>

    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">
        Processing
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Processed By</p>
            <p>{{ change.approver?.name }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Processed At</p>
            <p>{{ formatDate(change.approved_at) }}</p>
        </div>

    </div>

</div>

        

<div class="rounded-lg bg-white p-6 shadow dark:bg-gray-800 mb-6">

    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">
        History Details
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Type</p>
            <p>{{ change.type }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Performed By</p>
            <p>{{ change.performed_by }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Title</p>
            <p>{{ change.title }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Performed At</p>
            <p>{{ formatShortDate(change.performed_at) }}</p>
        </div>

        <div class="md:col-span-2">
            <p class="text-sm text-gray-500 dark:text-gray-400">Description</p>
            <p>{{ change.description }}</p>
        </div>

        <div class="md:col-span-2">
            <p class="text-sm text-gray-500 dark:text-gray-400">Remarks</p>
            <p>{{ change.remarks || '-' }}</p>
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
    class="px-6 py-2 rounded bg-red-600 text-white hover:bg-red-700 transition"
>
    ✕ Reject
</button>



     

    </div>

</div>



</div>
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
</MainLayout>
</template>
