<script setup>
defineProps({
    label: String,
    value: [String, Number],
    active: Boolean,
})
</script>

<template>
    <button
        class="rounded-lg border px-4 py-2 text-sm font-medium transition"
        :class="active
            ? 'bg-blue-600 text-white border-blue-600'
            : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-700'"
    >
        {{ label }}
        <span class="ml-2 font-semibold">
            {{ value }}
        </span>
    </button>
</template>
