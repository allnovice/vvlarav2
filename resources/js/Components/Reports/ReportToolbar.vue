<script setup>
import { reactive } from 'vue'

const props = defineProps({
    departments: Array,
    locations: Array,
    types: Array,
    statuses: Array,
    filters: Object,
})

const localFilters = reactive({
    department: props.filters.department ?? '',
    location: props.filters.location ?? '',
    type: props.filters.type ?? '',
    status: props.filters.status ?? '',
    search: props.filters.search ?? '',
})

const updateFilters = () => {
    emit('update:filters', localFilters)
}
const emit = defineEmits([
    'update:filters',
    'export',
])
const exportCsv = () => {
    emit('export')
}
</script>
<template>
    <div class="grid grid-cols-1 gap-4 p-4 border-b border-gray-200 md:grid-cols-4">

<div class="md:col-span-4">
    <label class="block text-sm font-medium mb-1">
        Search
    </label>

    <input
        v-model="localFilters.search"
        @input="updateFilters"
        type="text"
        placeholder="Search assets..."
        class="w-full rounded-md border-gray-300"
    />
</div>
        <div>
            <label class="block text-sm font-medium mb-1">Department</label>

            <select
                v-model="localFilters.department"
                @change="updateFilters"
                class="w-full rounded-md border-gray-300"
            >
                <option value="">All</option>

                <option
                    v-for="department in departments"
                    :key="department"
                    :value="department"
                >
                    {{ department }}
                </option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Location</label>

            <select
                v-model="localFilters.location"
                @change="updateFilters"
                class="w-full rounded-md border-gray-300"
            >
                <option value="">All</option>

                <option
                    v-for="location in locations"
                    :key="location"
                    :value="location"
                >
                    {{ location }}
                </option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Type</label>

            <select
                v-model="localFilters.type"
                @change="updateFilters"
                class="w-full rounded-md border-gray-300"
            >
                <option value="">All</option>

                <option
                    v-for="type in types"
                    :key="type"
                    :value="type"
                >
                    {{ type }}
                </option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Status</label>

            <select
                v-model="localFilters.status"
                @change="updateFilters"
                class="w-full rounded-md border-gray-300"
            >
                <option value="">All</option>

                <option
                    v-for="status in statuses"
                    :key="status"
                    :value="status"
                >
                    {{ status }}
                </option>
            </select>
        </div>

<button
    @click="exportCsv"
    type="button"
    class="rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700"
>
    Export CSV
</button>

    </div>
</template>
