<script setup>
import { router } from '@inertiajs/vue3'
import { watch, ref, onMounted } from 'vue'
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
onMounted(() => {
    const saved = localStorage.getItem('selectedQrAssets')

    if (saved) {
        selectedAssets.value = JSON.parse(saved)
    }
})
function toggleSelection(id, checked) {

    const asset = props.assets.data.find(a => a.id === id)

    if (!asset) return

    if (checked) {

        if (!selectedAssets.value.some(a => a.id === id)) {

            selectedAssets.value.push({
                id: asset.id,
                property_number: asset.property_number,
            })

        }

    } else {

        selectedAssets.value =
            selectedAssets.value.filter(a => a.id !== id)

    }

}
function removeSelection(id) {
    selectedAssets.value =
        selectedAssets.value.filter(asset => asset.id !== id)
}
function printSelected() {
    if (selectedAssets.value.length === 0) return

    router.visit(route('qr-labels.print', {
        ids: selectedAssets.value
            .map(asset => asset.id)
            .join(',')
    }))
}
function printPropertyCards() {
    router.visit(route('property-cards.print', {
        ids: selectedAssets.value
            .map(asset => asset.id)
            .join(',')
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
watch(selectedAssets, (value) => {
    localStorage.setItem(
        'selectedQrAssets',
        JSON.stringify(value)
    )
}, {
    deep: true
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
    @click="printPropertyCards"
    class="rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700"
    :disabled="selectedAssets.length === 0"
>
    Print Property Cards
</button>
 <button
    @click="printSelected"
    class="rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
    :disabled="selectedAssets.length === 0"
>
    Print Selected
</button>

</div>
<ul class="mt-2 space-y-1 text-sm">

    <li
        v-for="asset in selectedAssets"
        :key="asset.id"
        class="flex items-center justify-between rounded bg-gray-100 px-2 py-1 dark:bg-gray-800"
    >

        <span>
            {{ asset.property_number }}
        </span>

        <button
            @click="removeSelection(asset.id)"
            class="font-bold text-red-600 hover:text-red-800"
        >
            ✕
        </button>

    </li>

</ul>
<AssetTable
    :assets="assets.data"
    :selected-assets="selectedAssets"
    selectable
    @toggle-select="toggleSelection"
/>
<AssetPagination
    :links="assets.links"
/>
        </div>
    </MainLayout>
</template>
