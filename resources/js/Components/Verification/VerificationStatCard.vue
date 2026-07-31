<script setup>
import { computed } from 'vue'

const props = defineProps({
    title: String,
    value: [String, Number],
    active: {
        type: Boolean,
        default: false,
    },
})
const emit = defineEmits(['click'])
</script>
<template>
<div
    class="rounded-xl p-6 cursor-pointer transition duration-200"
    :class="active
        ? 'bg-blue-50 border-2 border-blue-500 shadow-md dark:bg-blue-900/20'
        : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md'"
    @click="emit('click')"
>
        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
            {{ title }}
        </div>

        <div class="mt-3 text-4xl font-bold text-gray-900 dark:text-white">
            {{ value }}
        </div>
    </div>
</template>
