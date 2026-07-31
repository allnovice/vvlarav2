<script setup>
import { computed } from 'vue'

const props = defineProps({
    title: String,
    value: [String, Number],
    color: {
        type: String,
        default: 'blue',
    },
})

const borderClass = computed(() => ({
    blue: 'border-blue-500',
    green: 'border-green-500',
    yellow: 'border-yellow-500',
    red: 'border-red-500',
}[props.color] ?? 'border-blue-500'))
</script>
<template>
    <div class="rounded-xl bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
            {{ title }}
        </div>

        <div class="mt-3 text-4xl font-bold text-gray-900 dark:text-white">
            {{ value }}
        </div>
    </div>
</template>
