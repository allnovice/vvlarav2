<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    value: {
        type: [String, Number],
        required: true,
    },
    description: {
        type: String,
        default: '',
    },
})
</script>

<template>
    <div
        class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm
               dark:border-gray-700 dark:bg-gray-800"
    >
        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
            {{ title }}
        </div>

        <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
            {{ value }}
        </div>

        <div
            v-if="description"
            class="mt-1 text-sm text-gray-500 dark:text-gray-400"
        >
            {{ description }}
        </div>
    </div>
</template>
