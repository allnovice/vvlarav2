<script setup>
import { computed } from 'vue'
import StatusBadge from '@/Components/Assets/StatusBadge.vue'

const props = defineProps({
    asset: Object,
})
const formattedVerifiedAt = computed(() => {
    if (!props.asset.verified_at) return null

    return new Date(props.asset.verified_at).toLocaleString()
})
const formattedNextVerificationDue = computed(() => {
    if (!props.asset.next_verification_due) return null

    return new Date(props.asset.next_verification_due).toLocaleDateString()
})
const isVerified = computed(() => {
    if (!props.asset.next_verification_due) return false

    return new Date(props.asset.next_verification_due) >= new Date()
})
</script>
<template>
        
    <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-800">

        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">
            Verification
        </h3>

        <div class="flex flex-wrap items-center gap-3">

            <StatusBadge
                :status="
                    isVerified
                        ? 'Verified'
                        : asset.pending_verification
                            ? 'Pending Verification'
                            : 'Not Verified'
                "
            />

            <template v-if="isVerified">

                <span class="text-sm text-gray-600 dark:text-gray-400">
                    Verified:
                    <span class="font-medium">{{ formattedVerifiedAt }}</span>
                </span>

                <span class="text-gray-300 dark:text-gray-600">|</span>

                <span class="text-sm text-gray-600 dark:text-gray-400">
                    Next Due:
                    <span class="font-medium">{{ formattedNextVerificationDue }}</span>
                </span>

            </template>

            <template v-else-if="asset.pending_verification">

                <span class="text-sm text-gray-600 dark:text-gray-400">
                    Awaiting approval
                </span>

            </template>

        </div>

    </div>
</template>
