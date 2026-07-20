<script setup>
import InfoRow from '@/Components/Assets/InfoRow.vue'
import StatusBadge from '@/Components/Assets/StatusBadge.vue'
import CardSection from '@/Components/Assets/CardSection.vue'
import { CubeIcon } from '@heroicons/vue/24/outline'
import TagChip from '@/Components/Assets/TagChip.vue'
import { Link } from '@inertiajs/vue3'
import ImageModal from '@/Components/ImageModal.vue'

defineProps({
    asset: Object,

    isAuthenticated: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits([
    'edit',
])

</script>

<template>

<div
    class="rounded-xl
       border
       border-blue-100
       bg-gradient-to-r
       from-blue-50
       to-white
       shadow-sm
       p-6"
>

    <div class="flex flex-col gap-6 md:flex-row md:justify-between md:items-start">

        <div>


<div class="flex flex-col items-center gap-4 sm:flex-row sm:items-start">

    <div class="w-32 h-32 rounded-xl overflow-hidden border">



<ImageModal
    v-if="asset.photo_path"
    :src="`/storage/${asset.photo_path}`"
    alt="Asset Photo"
    thumbnail-class="w-32 h-32 rounded-xl shadow-sm"
/>



        <div
            v-else
            class="w-32 h-32 rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 flex flex-col items-center justify-center"
        >
            <CubeIcon class="w-10 h-10 text-gray-400" />

            <p class="text-xs text-gray-400 mt-2">
                No Photo
            </p>
        </div>

    </div>

    <div>

        <p class="text-sm uppercase tracking-[0.2em] text-blue-600 font-semibold">
            {{ asset.brand || 'Unknown Brand' }}
        </p>

        <h2 class="text-3xl font-bold text-gray-900 mt-1">
            {{ asset.model || 'Unknown Model' }}
        </h2>

        <div class="mt-4">
            <p class="text-xs uppercase tracking-[0.2em] text-gray-400">
                Property Number
            </p>

            <p class="text-lg font-semibold text-gray-900">
                {{ asset.property_number }}
            </p>
        </div>

        <div class="flex flex-wrap gap-2 mt-4">

            <TagChip :value="asset.type" />

            <TagChip :value="asset.department || 'Unassigned'" />

            <TagChip :value="asset.location || 'No Location'" />

        </div>

    </div>







</div>



        </div>

        <div>



<div class="flex flex-col items-center gap-3 md:items-end">

    <StatusBadge
        :status="asset.status"
    />


<div class="mt-2">
    <span
        :class="asset.verified_at
            ? 'bg-green-100 text-green-700'
            : 'bg-yellow-100 text-yellow-700'"
        class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium"
    >
        {{ asset.verified_at ? '✓ Verified' : 'Not Verified' }}
    </span>
</div>



<button
    v-if="isAuthenticated"
    :disabled="!!asset.pending_change"
    @click="$emit('edit')"
    class="... disabled:opacity-25 disabled:cursor-not-allowed"
>
    Edit Asset
</button>

    <Link
        :href="route('assets.qr', asset.id)"
        class="w-full inline-flex justify-center items-center px-4 py-2
               bg-gray-700 text-white rounded-lg
               hover:bg-gray-800 transition"
    >
        Print QR
    </Link>

</div>



        </div>

    </div>

</div>
 
</template>
