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
<div class="border-b border-gray-200 p-4 dark:border-gray-700">

        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">


    <input
    :value="search"
    @input="emit('update:search', $event.target.value)"
    type="text"
    placeholder="Search assets..."
    class="w-full md:w-80 rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder:text-gray-400"
/>

<select
    :value="statusFilter"
    @change="emit('update:statusFilter', $event.target.value)"
    class="rounded-md border-gray-300 bg-white text-gray-900 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
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
