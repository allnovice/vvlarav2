<script setup>
defineProps({
    modelValue: String,
    placeholder: {
        type: String,
        default: 'Search assets...',
    },
})

const emit = defineEmits([
    'update:modelValue',
])
</script>

<template>
    <input
        :value="modelValue"
        @input="emit('update:modelValue', $event.target.value)"
        type="text"
        :placeholder="placeholder"
        class="w-full md:w-80 rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder:text-gray-400 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder:text-gray-400"
    />
</template>
