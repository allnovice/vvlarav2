<script setup>
import { ref } from 'vue'
import { useForm, usePage, router } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import RejectModal from '@/Components/Assets/RejectModal.vue'
import StatusBadge from '@/Components/StatusBadge.vue'
import ConfirmationModal from '@/Components/ConfirmationModal.vue'
import ImageModal from '@/Components/ImageModal.vue'

const page = usePage()
function back() {
    router.visit(route('asset-verifications.index'))
}
const props = defineProps({
    verification: Object,
})

const form = useForm({
    reviewer_remarks: '',
})

const showRejectModal = ref(false)
const showApproveModal = ref(false);

function approve() {
    showApproveModal.value = false

    form.post(route('asset-verifications.approve', props.verification.id))
}

function submitReject() {
    form.post(
        route('asset-verifications.reject', props.verification.id),
        {
            onSuccess: () => {
                showRejectModal.value = false
                form.reset()
            },
        }
    )
}

function formatDate(date) {
    if (!date) return '—'

    return new Date(date).toLocaleString()
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
            Verification Request
        </h2>

    </div>
</template>


    <div class="py-6 px-6">

<div
    v-if="page.props.errors.verification"
    class="mb-4 rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700 dark:border-red-700 dark:bg-red-900/40 dark:text-red-300"
>
    {{ page.props.errors.verification }}
</div>


<div class="rounded-lg bg-white p-6 shadow dark:bg-gray-800 mb-6">
    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">
        Verification Request
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Submitted By</p>
            
            <p class="text-gray-900 dark:text-gray-100">{{ verification.user.name }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Asset</p>
            <p class="text-gray-900 dark:text-gray-100">{{ verification.asset.property_number }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
            <StatusBadge :status="verification.status" />
        </div>

    </div>

</div>



<div
    v-if="verification.status !== 'pending'"
    class="bg-white rounded-lg shadow p-6 mb-6"
>

    <h3 class="text-lg font-semibold mb-4">
        Review
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
<p class="text-sm text-gray-500 dark:text-gray-400">Reviewed By</p>
<p class="text-gray-900 dark:text-gray-100">
    {{ verification.reviewer?.name || '-' }}
</p>
        </div>

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Reviewed At</p>
<p class="text-gray-900 dark:text-gray-100">
    {{ formatDate(verification.reviewed_at) }}
</p>
        </div>

        <div class="md:col-span-2">
            <p class="text-sm text-gray-500 dark:text-gray-400">Reviewer Remarks</p>
<p class="text-gray-900 dark:text-gray-100">
    {{ verification.reviewer_remarks || '-' }}
</p>
        </div>

    </div>

</div>

  


<div class="rounded-lg bg-white p-6 shadow dark:bg-gray-800 mb-6">

    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">
        Verification Details
    </h3>

    <div class="grid grid-cols-1 gap-6">

        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Remarks</p>
            <p class="text-gray-900 dark:text-gray-100">
{{ verification.remarks || '-' }}</p>
        </div>

        <div>

            <p class="text-sm text-gray-500 mb-2">
                Attachment
            </p>

            <a
                v-if="verification.attachment_path"
                :href="`/storage/${verification.attachment_path}`"
                target="_blank"
                class="inline-block rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
            >
                Download Attachment
            </a>

            <p
                v-else
                class="text-gray-500 dark:text-gray-400"
            >
                No attachment.
            </p>

        </div>

    </div>

</div>




<div>

    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
        Photos
    </p>

    <div
        v-if="verification.photos.length"
        class="flex flex-wrap gap-2"
    >

        <ImageModal
            v-for="photo in verification.photos"
            :key="photo.id"
            :src="`/storage/${photo.photo_path}`"
            :thumbnail-src="`/storage/${photo.photo_thumb_path}`"
            thumbnail-class="h-20 w-20 rounded-lg border object-cover"
        />

    </div>

    <p
        v-else
        class="text-gray-500 dark:text-gray-400"
    >
        No photos.
    </p>

</div>






<div
    v-if="verification.status === 'pending'"
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

<RejectModal
    :show="showRejectModal"
    :form="form"
    @close="showRejectModal = false"
    @submit="submitReject"
/>
<ConfirmationModal
    :show="showApproveModal"
    title="Approve Asset Change"
    message="Are you sure you want to approve this asset change?"
    confirm-text="Approve"
    @close="showApproveModal = false"
    @confirm="approve(props.verification.id)"
/>
</MainLayout>
</template>
