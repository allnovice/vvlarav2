<script setup>
import InfoRow from '@/Components/Assets/InfoRow.vue'
import StatusBadge from '@/Components/Assets/StatusBadge.vue'
import CardSection from '@/Components/Assets/CardSection.vue'
import { CubeIcon } from '@heroicons/vue/24/outline'
import TagChip from '@/Components/Assets/TagChip.vue'

defineProps({
    asset: Object,
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

    <div class="flex justify-between items-start">

        <div>


<div class="flex items-start gap-4">

    <!-- Placeholder for future asset photo -->

<div class="w-32 h-32 rounded-xl overflow-hidden border">

    <img
        v-if="asset.photo_path"
        :src="`/storage/${asset.photo_path}`"
        alt="Asset Photo"
        class="w-full h-full object-cover"
    />

    <div
        v-else
        class="w-full h-full flex items-center justify-center bg-gray-100"
    >
        <CubeIcon class="w-12 h-12 text-gray-400" />
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

    <p
        class="text-xs
               uppercase
               tracking-[0.2em]
               text-gray-400"
    >
        Property Number
    </p>

    <p
        class="text-lg
               font-semibold
               text-gray-900"
    >
        {{ asset.property_number }}
    </p>

</div>



<div class="flex flex-wrap gap-2 mt-4">

    <TagChip
        :value="asset.type"
    />

    <TagChip
        :value="asset.department || 'Unassigned'"
    />

    <TagChip
        :value="asset.location || 'No Location'"
    />

</div>



    </div>

</div>



        </div>

        <div>



<div class="flex flex-col items-end gap-4">

    <StatusBadge
        :status="asset.status"
    />

    <button
        @click="$emit('edit')"
        class="inline-flex items-center gap-2 px-4 py-2
               bg-blue-600 text-white rounded-lg
               hover:bg-blue-700 transition"
    >
        Edit Asset
    </button>

</div>



        </div>

    </div>

</div>
 
</template>
