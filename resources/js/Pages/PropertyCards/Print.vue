<script setup>

import MainLayout from '@/Layouts/MainLayout.vue'
import PropertyCard from '@/Components/PropertyCards/PropertyCard.vue'
import { ref } from 'vue'

const props = defineProps({
    assets: Array,
})
const editingCard = ref(null)
const cards = ref(
    props.assets.map(asset => ({
        ...asset,

        print: {
            date: '',
            coaRepresentative: '',
            inventoryOfficer: '',
            location: asset.location ?? '',
            physicalCondition: '',
        },
    }))
)
function editCard(card) {
    editingCard.value = card
}
function printCards() {
    window.print()
}
</script>

<template>
<button
    @click="printCards"
    class="fixed bottom-4 right-4 rounded bg-blue-600 px-4 py-2 text-white shadow print:hidden"
>
    Print
</button>
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4 print:hidden">
                Property Card Preview
            </h1>

            <p class="print:hidden">Selected IDs:</p>
<div
    v-if="editingCard"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
>
    <div class="w-full max-w-lg rounded-lg bg-white p-6 shadow-xl">

        <h2 class="mb-4 text-xl font-bold text-black">
            Edit Property Card
        </h2>


<div class="space-y-4">

<div>
    <label class="mb-1 block text-sm font-medium text-black">
        Property No.
    </label>

    <input
        v-model="editingCard.property_number"
        class="w-full rounded border px-3 py-2 text-black"
    >
</div>

<div>
    <label class="mb-1 block text-sm font-medium text-black">
        Description
    </label>

    <input
        v-model="editingCard.description"
        class="w-full rounded border px-3 py-2 text-black"
    >
</div>  



    <div>
        <label class="mb-1 block text-sm font-medium text-black">
            Date
        </label>

        <input
            v-model="editingCard.print.date"
            type="date"
            class="w-full rounded border px-3 py-2 text-black"
        >
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-black">
            COA Representative
        </label>

        <input
            v-model="editingCard.print.coaRepresentative"
            class="w-full rounded border px-3 py-2 text-black"
        >
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-black">
            Inventory Officer
        </label>

        <input
            v-model="editingCard.print.inventoryOfficer"
            class="w-full rounded border px-3 py-2 text-black"
        >
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-black">
            Location
        </label>

        <input
            v-model="editingCard.print.location"
            class="w-full rounded border px-3 py-2 text-black"
        >
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-black">
            Physical Condition
        </label>

        <select
            v-model="editingCard.print.physicalCondition"
            class="w-full rounded border px-3 py-2 text-black"
        >
            <option value=""></option>
            <option>New</option>
            <option>Good</option>
            <option>Fair</option>
            <option>Poor</option>
            <option>Unserviceable</option>
        </select>
    </div>

</div>


        <div class="flex justify-end gap-2">

            <button
                @click="editingCard = null"
                class="rounded bg-gray-500 px-4 py-2 text-white"
            >
                Close
            </button>

        </div>

    </div>
</div>
<div class="grid grid-cols-2 gap-6">
    <PropertyCard
        v-for="card in cards"
        :key="card.id"
        :card="card"
        @edit="editCard"
    />
</div>

        </div>
</template>
