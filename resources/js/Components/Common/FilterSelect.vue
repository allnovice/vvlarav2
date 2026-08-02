<script setup>
defineProps({
    label: String,
    modelValue: [String, Number],
    options: {
        type: Array,
        default: () => [],
    },
})

defineEmits(['update:modelValue'])

</script>

<template>
    <div class="flex flex-col gap-1">
        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ label }}
        </label>

        <select
            :value="modelValue"
            @change="$emit('update:modelValue', $event.target.value)"
            class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white"
        >
            <option
                v-for="option in options"
                :key="option"
                :value="option"
            >
                {{ option }}
            </option>
        </select>
    </div>
</template>
