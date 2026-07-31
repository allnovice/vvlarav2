<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'
import Modal from '@/Components/Modal.vue'
import AssetSearchInput from '@/Components/Assets/AssetSearchInput.vue'

const props = defineProps({
    show: Boolean,
    asset: Object,
})
const emit = defineEmits(['close'])
const selectedAsset = ref(null)
const search = ref('')
const results = ref([])
watch(search, async (value) => {

    if (value.length < 2) {
        results.value = []
        return
    }

    const { data } = await axios.get(route('assets.search'), {
        params: {
            q: value,
        },
    })

    results.value = data
})
async function linkParent() {

    console.log('props.asset =', props.asset)
    console.log('selectedAsset =', selectedAsset.value)
    await axios.post(
        route('assets.link-parent', props.asset.id),
        {
            parent_asset_id: selectedAsset.value.id,
        }
    )

    window.location.reload()
}
</script>

<template>
    <Modal :show="show" @close="emit('close')">
        <div class="p-6">

            <h2 class="text-lg font-semibold">
                Link Parent Asset
            </h2>

            <div class="mt-4">
                <AssetSearchInput
                    v-model="search"
                    placeholder="Search property number, brand or model..."
                />

<div
    v-if="results.length"
    class="mt-3 max-h-72 overflow-y-auto rounded-lg border"
>


<button
    v-for="asset in results"
    :key="asset.id"
    type="button"
    @click="selectedAsset = asset"
    :class="[
        'block w-full border-b p-3 text-left',
        selectedAsset?.id === asset.id
            ? 'bg-blue-100 dark:bg-blue-900'
            : 'hover:bg-gray-100 dark:hover:bg-gray-700'
    ]"
>
<div class="font-medium">
            {{ asset.property_number }}
        </div>

        <div class="text-sm text-gray-500">
            {{ asset.type }} • {{ asset.brand }} {{ asset.model }}
        </div>
    </button>


</div>


            </div>

<div class="mt-6 flex justify-end gap-2">

    <button
        @click="emit('close')"
        class="rounded-lg border px-4 py-2"
    >
        Cancel
    </button>

    <button
        :disabled="!selectedAsset"
        @click="linkParent"
        class="rounded-lg bg-blue-600 px-4 py-2 text-white
               disabled:opacity-50"
    >
        Link
    </button>

</div>

        </div>
    </Modal>
</template>
