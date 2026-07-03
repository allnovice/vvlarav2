<script setup>
import { useForm } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
    asset: Object,
})

const form = useForm({})

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

        <div v-else>

            <span
                class="rounded-full bg-yellow-100 px-3 py-1 text-sm font-medium text-yellow-700"
            >
                Not Verified
            </span>

            <div class="mt-6">

                <button
                    @click="form.patch(route('assets.verify', asset.id))"
                    :disabled="form.processing"
                    class="rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700 disabled:opacity-50"
                >
                    {{ form.processing ? 'Verifying...' : 'Verify Asset' }}
                </button>

            </div>

        </div>

    </div>
</template>
