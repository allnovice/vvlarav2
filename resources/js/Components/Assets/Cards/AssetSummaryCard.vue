<script setup>
import InfoRow from '@/Components/Assets/InfoRow.vue'
import StatusBadge from '@/Components/Assets/StatusBadge.vue'
import CardSection from '@/Components/Assets/CardSection.vue'
import { CubeIcon } from '@heroicons/vue/24/outline'

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
           border-gray-200
           bg-white
           shadow-sm
           p-6"
>

    <div class="flex justify-between items-start">

        <div>


<div class="flex items-start gap-4">

    <!-- Placeholder for future asset photo -->

    <div
        class="w-20 h-20
               rounded-xl
               bg-gray-100
               border
               flex
               items-center
               justify-center"
    >

        <CubeIcon class="w-10 h-10 text-gray-400" />

    </div>

    <div>

        <h2 class="text-2xl font-bold text-gray-900">
            {{ asset.brand || 'Unknown Brand' }}
            {{ asset.model || '' }}
        </h2>

        <p class="text-gray-500 mt-1">
            Property No. {{ asset.property_number }}
        </p>

        <p class="text-gray-500 mt-2">
            {{ asset.type }}
            •
            {{ asset.department || 'Unassigned' }}
            •
            {{ asset.location || 'No Location' }}
        </p>

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
