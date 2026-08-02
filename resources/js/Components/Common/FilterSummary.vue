<script setup>
import { computed } from 'vue'

const props = defineProps({
    count: {
        type: Number,
        required: true,
    },
    filters: {
        type: Array,
        default: () => [],
    },
})

const activeFilters = computed(() =>
    props.filters.filter(filter => filter.value && filter.value !== 'All')
)
</script>

<template>
    <div class="rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm dark:border-gray-700 dark:bg-gray-800">
        <template v-if="activeFilters.length">
            <span class="font-medium">Showing:</span>

            <span
                v-for="(filter, index) in activeFilters"
                :key="filter.label"
            >
                {{ filter.value }}<span v-if="index < activeFilters.length - 1"> • </span>
            </span>
        </template>

        <template v-else>
            <span class="font-medium">Showing: All Assets</span>
        </template>

<span
    class="ml-3 inline-flex items-center rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-300"
>
    {{ count }} assets
</span>
    </div>
</template>
