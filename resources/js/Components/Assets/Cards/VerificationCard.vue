<script setup>
import { useForm, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import { ref } from 'vue'
import VerificationModal from '@/Components/Assets/VerificationModal.vue'

const props = defineProps({
    asset: Object,
})

const showVerificationModal = ref(false)

const form = useForm({
    remarks: '',
    attachment: null,
})

const submitVerification = () => {
    form.post(route('asset-verifications.store', props.asset.id), {
        forceFormData: true,

        onSuccess: () => {
            showVerificationModal.value = false
            form.reset()
        },
    })
}

const page = usePage()
const isAdmin = computed(() => {
    return page.props.auth?.user?.role === 'admin'
})
const formattedVerifiedAt = computed(() => {
    if (!props.asset.verified_at) return null

    return new Date(props.asset.verified_at).toLocaleString()
})
</script>
<template>
    <div class="rounded-xl border border-gray-200 bg-white p-6">

        <h3 class="mb-4 text-lg font-semibold">
            Verification
        </h3>

        <div v-if="asset.verified_at">

            <span
                class="rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-700"
            >
                ✓ Verified
            </span>

            <p class="mt-4 text-sm text-gray-600">
                Verified on
                {{ formattedVerifiedAt }}
            </p>

        </div>



<div v-else-if="asset.pending_verification">

    <span
        class="rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-700"
    >
        Pending Verification
    </span>

    <p class="mt-4 text-sm text-gray-600">
        A verification request has been submitted and is awaiting approval.
    </p>

    <div class="mt-6">
        <button
            disabled
            class="rounded-lg bg-gray-400 px-4 py-2 text-white cursor-not-allowed"
        >
            Verification Pending
        </button>
    </div>

</div>

<div v-else>




            <span
                class="rounded-full bg-yellow-100 px-3 py-1 text-sm font-medium text-yellow-700"
            >
                Not Verified
            </span>

            <div class="mt-6">

                <button
                    @click="showVerificationModal = true"
                    :disabled="form.processing"
                    class="rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700 disabled:opacity-50"
                >
                    {{ form.processing ? 'Verifying...' : 'Verify Asset' }}
                </button>

            </div>

        </div>

    </div>

<VerificationModal
    :show="showVerificationModal"
    :form="form"
    @close="showVerificationModal = false"
    @submit="submitVerification"
/>

</template>
