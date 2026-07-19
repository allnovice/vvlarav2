<script setup>
import { Link } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

const props = defineProps({
    types: Array,
    locations: Array,
    departments: Array,
    assets: Array,
})

const selectedType = ref('All')
const selectedLocation = ref('All')
const selectedDepartment = ref('All')

const typeCount = computed(() => {
    if (selectedType.value === 'All') {
        return props.assets.length
    }

    return props.assets.filter(asset => asset.type === selectedType.value).length
})

const locationCount = computed(() => {
    if (selectedLocation.value === 'All') {
        return props.assets.length
    }

    return props.assets.filter(asset => asset.location === selectedLocation.value).length
})

const departmentCount = computed(() => {
    if (selectedDepartment.value === 'All') {
        return props.assets.length
    }

    return props.assets.filter(asset => asset.department === selectedDepartment.value).length
})
</script>

<template>
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="mb-4 text-lg font-semibold">
            Asset Overview
        </h2>

<div class="mb-6 rounded-md bg-gray-50 p-3 text-sm">
    <div class="flex flex-wrap gap-x-6 gap-y-2">
        <span><strong>Assets:</strong> {{ totalAssets }}</span>
        <span><strong>Active:</strong> {{ activeAssets }}</span>
        <span><strong>Repair:</strong> {{ underRepairAssets }}</span>
        <span><strong>Borrowed:</strong> {{ borrowedAssets }}</span>
        <span><strong>Archived:</strong> {{ archivedAssets }}</span>
    </div>
</div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            <div>
                <label class="mb-1 block text-sm font-medium">
                    Type
                </label>

<select
    v-model="selectedType"
    class="w-full rounded-md border-gray-300"
>

                    <option>All</option>

                    <option
                        v-for="type in types"
                        :key="type"
                    >
                        {{ type }}
                    </option>
                </select>

<div class="mt-2">
    <Link
        :href="route('assets', { search: selectedType === 'All' ? '' : selectedType })"
        class="text-sm font-semibold text-blue-600 hover:underline"
    >
        {{ typeCount }} Assets
    </Link>
</div>

            </div>

            <div>
                <label class="mb-1 block text-sm font-medium">
                    Location
                </label>

<select
    v-model="selectedLocation"
    class="w-full rounded-md border-gray-300"
>

                    <option>All</option>

                    <option
                        v-for="location in locations"
                        :key="location"
                    >
                        {{ location }}
                    </option>
                </select>

<Link
    :href="route('assets', { search: selectedLocation === 'All' ? '' : selectedLocation })"
    class="text-sm font-semibold text-blue-600 hover:underline"
>
    {{ locationCount }} Assets
</Link>

            </div>

            <div>
                <label class="mb-1 block text-sm font-medium">
                    Department
                </label>

<select
    v-model="selectedDepartment"
    class="w-full rounded-md border-gray-300"
>

                    <option>All</option>

                    <option
                        v-for="department in departments"
                        :key="department"
                    >
                        {{ department }}
                    </option>
                </select>

<Link
    :href="route('assets', { search: selectedDepartment === 'All' ? '' : selectedDepartment })"
    class="text-sm font-semibold text-blue-600 hover:underline"
>
    {{ departmentCount }} Assets
</Link>

            </div>

        </div>
    </div>
</template>
