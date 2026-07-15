<script setup>
import { ref } from 'vue'
import { useForm, usePage, router } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import RejectModal from '@/Components/Assets/RejectModal.vue'
import StatusBadge from '@/Components/StatusBadge.vue'

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

function approve() {
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
            class="px-3 py-1 text-sm border rounded hover:bg-gray-100"
        >
            ← Back
        </button>

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Verification Request
        </h2>

    </div>
</template>


    <div class="py-6 px-6">

<div
    v-if="page.props.errors.verification"
    class="mb-4 rounded bg-red-100 border border-red-400 text-red-700 px-4 py-3"
>
    {{ page.props.errors.verification }}
</div>

<div class="bg-white rounded-lg shadow p-6 mb-6">

    <h3 class="text-lg font-semibold mb-4">
        Verification Request
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
            <p class="text-sm text-gray-500">Submitted By</p>
            <p>{{ verification.user.name }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Asset</p>
            <p>{{ verification.asset.property_number }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Status</p>
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
            <p class="text-sm text-gray-500">Reviewed By</p>
            <p>{{ verification.reviewer?.name || '-' }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Reviewed At</p>
            <p>{{ formatDate(verification.reviewed_at) }}</p>
        </div>

        <div class="md:col-span-2">
            <p class="text-sm text-gray-500">Reviewer Remarks</p>
            <p>{{ verification.reviewer_remarks || '-' }}</p>
        </div>

    </div>

</div>

  


<div class="bg-white rounded-lg shadow p-6 mb-6">

    <h3 class="text-lg font-semibold mb-4">
        Verification Details
    </h3>

    <div class="grid grid-cols-1 gap-6">

        <div>
            <p class="text-sm text-gray-500">Remarks</p>
            <p>{{ verification.remarks || '-' }}</p>
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
                class="text-gray-500"
            >
                No attachment.
            </p>

        </div>

    </div>

</div>








<div
    v-if="verification.status === 'pending'"
    class="bg-white rounded-lg shadow p-6"
>

    <h3 class="text-lg font-semibold mb-4">
        Actions
    </h3>

    <div class="flex gap-4">

        <button
            @click="approve"
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

</MainLayout>
</template>
