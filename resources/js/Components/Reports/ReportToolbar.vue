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
    <div class="grid grid-cols-1 gap-4 border-b border-gray-200 p-4 dark:border-gray-700 md:grid-cols-4">

<div class="md:col-span-4">
    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
        Search
    </label>

    <input
        v-model="localFilters.search"
        @input="updateFilters"
        type="text"
        placeholder="Search assets..."
        class="w-full rounded-md border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
    />
</div>
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>

            <select
                v-model="localFilters.department"
                @change="updateFilters"
                class="w-full rounded-md border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
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
            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>

            <select
                v-model="localFilters.location"
                @change="updateFilters"
                class="w-full rounded-md border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
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
            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>

            <select
                v-model="localFilters.type"
                @change="updateFilters"
                class="w-full rounded-md border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
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
            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>

            <select
                v-model="localFilters.status"
                @change="updateFilters"
                class="w-full rounded-md border-gray-300 bg-white text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
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
    class="rounded-md bg-green-600 px-4 py-2 text-white transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
>
    Export CSV
</button>

    </div>
</template>
