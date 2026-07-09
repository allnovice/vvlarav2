<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import RejectVerificationModal from '@/Components/Assets/RejectVerificationModal.vue'

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

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Verification Requests
        </h2>

    </template>

    <div class="py-6 px-6">



    

    <p>
        <strong>Submitted By:</strong>
        {{ verification.user.name }}
    </p>

    <p>
        <strong>Asset:</strong>
        {{ verification.asset.property_number }}
    </p>

    <p>
        <strong>Status:</strong>
        {{ verification.status }}
    </p>

    <div
        v-if="verification.status !== 'pending'"
        class="mt-4"
    >

        <p>
            <strong>Reviewed By:</strong>
            {{ verification.reviewer?.name || '—' }}
        </p>

        <p>
            <strong>Reviewed At:</strong>
            {{ formatDate(verification.reviewed_at) }}
        </p>

        <p>
            <strong>Reviewer Remarks:</strong>
            {{ verification.reviewer_remarks || '—' }}
        </p>

    </div>

    <hr class="my-6">

    <p>
        <strong>Remarks:</strong>
        {{ verification.remarks || 'No remarks provided.' }}
    </p>

    <div class="mt-4">

        <strong>Attachment:</strong>

        <div class="mt-2">

            <a
                v-if="verification.attachment_path"
                :href="`/storage/${verification.attachment_path}`"
                target="_blank"
                class="text-blue-600 hover:underline"
            >
                Download Attachment
            </a>

            <span
                v-else
                class="text-gray-500"
            >
                No attachment.
            </span>

        </div>

    </div>

    <div
        v-if="verification.status === 'pending'"
        class="mt-8 flex gap-3"
    >

        <button
            @click="approve"
            class="rounded bg-green-600 px-4 py-2 text-white"
        >
            Approve
        </button>

        <button
            @click="showRejectModal = true"
            class="rounded bg-red-600 px-4 py-2 text-white"
        >
            Reject
        </button>

    </div>

</div>

<RejectVerificationModal
    :show="showRejectModal"
    :form="form"
    @close="showRejectModal = false"
    @submit="submitReject"
/>

</MainLayout>
</template>
