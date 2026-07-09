<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue'

defineProps({
    search: String,
    statusFilter: String,
    isAuthenticated: {
        type: Boolean,
        default: false,
    },
})
const emit = defineEmits([
    'update:search',
    'update:statusFilter',
    'addAsset',
])


</script>

<template>

<div class="p-4 border-b border-gray-200">

        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">


    <input
    :value="search"
    @input="emit('update:search', $event.target.value)"
    type="text"
    placeholder="Search assets..."
    class="border rounded-md px-3 py-2 w-80"
/>

<select
    :value="statusFilter"
    @change="emit('update:statusFilter', $event.target.value)"
    class="rounded-md border-gray-300 shadow-sm"
>
    <option>All</option>
    <option>Active</option>
    <option>Under Repair</option>
    <option>Borrowed</option>
    <option>Archived</option>
</select>



<PrimaryButton
    v-if="isAuthenticated"
    @click="emit('addAsset')"
>
    + Add Asset
</PrimaryButton>

</div>
</div>

</template>
