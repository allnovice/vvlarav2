<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import HistoryModal from '@/Components/Assets/HistoryModal.vue'

defineProps({
    asset: Object,
})

const showModal = ref(false)
</script>

<template>
    <div class="rounded-xl border border-gray-200 bg-white p-6">

        <div class="flex items-center justify-between mb-6">

            <h3 class="text-lg font-semibold">
                Asset History
            </h3>

            <div class="flex gap-2">


<button
    @click="showModal = true"
    class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
>
    + Add History
</button>

            </div>

        </div>

        <div v-if="asset.history.length === 0">

            <p class="text-sm text-gray-500">
                No history has been recorded for this asset.
            </p>

        </div>



<div class="space-y-4">

    <div
        v-for="entry in asset.history"
        :key="entry.id"
        class="rounded-lg border border-gray-200 p-4"
    >

        <div class="flex items-center justify-between">

            
<component
    :is="entry.asset_history_change_id ? Link : 'span'"
    :href="entry.asset_history_change_id
        ? route('asset-history-changes.show', entry.asset_history_change_id)
        : undefined"
    :class="[
        entry.type === 'maintenance'
            ? 'bg-blue-100 text-blue-700'
            : 'bg-orange-100 text-orange-700',
        'rounded-full px-3 py-1 text-xs font-semibold capitalize',
        entry.asset_history_change_id ? 'hover:opacity-80 cursor-pointer' : ''
    ]"
>
    {{ entry.type }}
</component>



            <span class="text-sm text-gray-500">



{{ new Date(entry.performed_at).toLocaleDateString(undefined, {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
}) }}


            </span>

        </div>

        <h4 class="mt-3 font-semibold">
            {{ entry.title }}
        </h4>

        <p
            v-if="entry.description"
            class="mt-2 text-gray-600"
        >
            {{ entry.description }}
        </p>

        <p
            v-if="entry.remarks"
            class="mt-3 text-sm italic text-gray-500"
        >
            {{ entry.remarks }}
        </p>

    </div>

</div>



    </div>

<HistoryModal
    :show="showModal"
    :asset="asset"
    @close="showModal = false"
/>

</template>
