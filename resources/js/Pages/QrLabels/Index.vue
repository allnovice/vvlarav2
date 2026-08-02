<script setup>
import { router } from '@inertiajs/vue3'
import { watch, ref } from 'vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import AssetSearchInput from '@/Components/Assets/AssetSearchInput.vue'
import AssetTable from '@/Components/Assets/AssetTable.vue'
import AssetPagination from '@/Components/Assets/AssetPagination.vue'

const props = defineProps({
    assets: Object,
    search: String,
})
const search = ref(props.search ?? '')
const selectedAssets = ref([])

function toggleSelection(id) {
    const index = selectedAssets.value.indexOf(id)

    if (index === -1) {
        selectedAssets.value.push(id)
    } else {
        selectedAssets.value.splice(index, 1)
    }
}
function printSelected() {
    if (selectedAssets.value.length === 0) return

    router.visit(route('qr-labels.print', {
        ids: selectedAssets.value.join(',')
    }))
}
watch(search, (value) => {
    router.get(route('qr-labels.index'), {
        search: value,
    }, {
        preserveState: true,
        replace: true,
    })
})
</script>

<template>
    <MainLayout>
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-6">
                QR Labels
            </h1>

<AssetSearchInput
    v-model="search"
/>
<div class="mb-4 flex items-center justify-between">

    <div class="text-sm text-gray-600">
        Selected: {{ selectedAssets.length }}
    </div>
 
 <button
    @click="printSelected"
    class="rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
    :disabled="selectedAssets.length === 0"
>
    Print Selected
</button>

</div>
<AssetTable
    :assets="assets.data"
    selectable
    @toggle-select="toggleSelection"
/>
<AssetPagination
    :links="assets.links"
/>
        </div>
    </MainLayout>
</template>
