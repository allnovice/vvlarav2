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
    router.post(route('asset-photo-changes.approve', id))
}

function reject(id) {
    showRejectModal.value = false
    router.post(route('asset-photo-changes.reject', id))
}

function formatDate(date) {
    if (!date) return '-'
    return new Date(date).toLocaleString()
}

function back() {
    router.visit(route('asset-photo-changes.index'))
}
</script>

<template>

<MainLayout>

<template #header>

<div class="flex items-center gap-4">

<button
    @click="back"
    class="px-3 py-1 text-sm border rounded hover:bg-gray-100"
>
    ← Back
</button>

<h2 class="font-semibold text-xl text-gray-800">
    Photo Change Request
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

    <!-- Request -->

    <div class="rounded-lg bg-white p-6 shadow dark:bg-gray-800 mb-6">

        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">
            Request Information
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Requested By</p>
                <p>{{ change.user.name }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                <StatusBadge :status="change.status" />
            </div>

<div>
    <p class="text-sm text-gray-500 dark:text-gray-400">Action</p>
    <p class="capitalize">{{ change.action }}</p>
</div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Submitted</p>
                <p>{{ formatDate(change.created_at) }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Caption</p>
                <p>{{ change.caption || '-' }}</p>
            </div>

        </div>

    </div>

    <!-- Asset -->

    <div class="rounded-lg bg-white p-6 shadow dark:bg-gray-800 mb-6">

        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">
            Asset Information
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Property Number</p>
                <p>{{ change.asset.property_number }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Type</p>
                <p>{{ change.asset.type }}</p>
            </div>

            <div class="md:col-span-2">
                <p class="text-sm text-gray-500 dark:text-gray-400">Description</p>
                <p>{{ change.asset.description }}</p>
            </div>

        </div>

    </div>

    <!-- Photo -->

    <div class="rounded-lg bg-white p-6 shadow dark:bg-gray-800 mb-6">

        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">
            Photo Preview
        </h3>

        <div class="flex justify-center">


<ImageModal
    :src="`/storage/${change.photo_path}`"
    alt="Asset Photo"
    thumbnail-class="max-w-full md:max-w-md rounded-lg border shadow"
/>



        </div>

    </div>

    <!-- Processing -->

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
                <p>{{ formatDate(change.reviewed_at) }}</p>
            </div>

        </div>

    </div>

    <!-- Actions -->

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

</MainLayout>

<ConfirmationModal
    :show="showApproveModal"
    title="Approve Photo Upload"
    message="Are you sure you want to approve this photo upload?"
    confirm-text="Approve"
    @close="showApproveModal = false"
    @confirm="approve(change.id)"
/>

<ConfirmationModal
    :show="showRejectModal"
    title="Reject Photo Upload"
    message="Are you sure you want to reject this photo upload?"
    confirm-text="Reject"
    @close="showRejectModal = false"
    @confirm="reject(change.id)"
/>

</template>
