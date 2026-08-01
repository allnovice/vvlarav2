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
    canApprove: Boolean,
    isAuthenticated: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits([
    'edit',
    'link-parent',
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
       p-6
       shadow-sm
       dark:border-blue-800
       dark:from-gray-800
       dark:to-gray-900"
>

    <div class="flex flex-col gap-6 md:flex-row md:justify-between md:items-start">

        <div>


<div class="flex flex-col items-center gap-4 sm:flex-row sm:items-start">

    <div class="w-32 h-32 rounded-xl overflow-hidden border">




<ImageModal
    v-if="asset.photo_path"
    :src="`/storage/${asset.photo_path}`"
    :thumbnail-src="`/storage/${asset.photo_thumb_path ?? asset.photo_path}`"
    alt="Asset Photo"
    thumbnail-class="w-32 h-32 rounded-xl shadow-sm"
/>


        <div
            v-else
            class="flex h-32 w-32 flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-800"
        >
            <CubeIcon class="w-10 h-10 text-gray-400 dark:text-gray-500" />

            <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">
                No Photo
            </p>
        </div>

    </div>

    <div>

        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-600 dark:text-blue-400">
            {{ asset.brand || 'Unknown Brand' }}
        </p>

        <h2 class="mt-1 text-3xl font-bold text-gray-900 dark:text-gray-100">
            {{ asset.model || 'Unknown Model' }}
        </h2>

        <div class="mt-4">
            <p class="text-xs uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500">
                Property Number
            </p>

            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
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
        :href="route('assets.print-qr', asset.id)"
        class="w-full inline-flex justify-center items-center px-4 py-2
               bg-gray-700 text-white rounded-lg
               hover:bg-gray-800 transition"
    >
        Print QR
    </Link>

</div>


<button
    v-if="isAuthenticated && canApprove"
    :disabled="!!asset.parent_asset_id || asset.is_parent"
    @click="$emit('link-parent')"
    class="w-full inline-flex justify-center items-center px-4 py-2
           bg-indigo-600 text-white rounded-lg
           hover:bg-indigo-700
           disabled:bg-gray-300
           disabled:cursor-not-allowed"
>
    {{
        asset.parent_asset_id
            ? 'Already Linked'
            : asset.is_parent
                ? 'Parent Asset'
                : 'Link Asset'
    }}
</button>



        </div>

    </div>



<div v-if="asset.children?.length" class="mt-6 border-t pt-4">
    <p class="text-sm font-semibold text-gray-500">
        Linked Assets
    </p>

    <ul class="mt-2 space-y-2">
        <li
            v-for="child in asset.children"
            :key="child.id"
        >
            <Link
                :href="route('assets.show', child.id)"
                class="text-blue-600 hover:underline"
            >
                {{ child.property_number }}
            </Link>

            <div class="text-sm text-gray-500">
                {{ child.type }} • {{ child.brand }} {{ child.model }}
            </div>
        </li>
    </ul>
</div>

<div
    v-if="asset.parent"
    class="mt-6 border-t border-gray-200 pt-4 dark:border-gray-700"
>
    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">
        Parent Asset
    </p>

    <Link
        :href="route('assets.show', asset.parent.id)"
        class="mt-1 inline-block text-blue-600 hover:underline dark:text-blue-400"
    >
        {{ asset.parent.property_number }}
    </Link>

    <p class="text-sm text-gray-500">
        {{ asset.parent.brand }} {{ asset.parent.model }}
    </p>
</div>



</div>
 
</template>
