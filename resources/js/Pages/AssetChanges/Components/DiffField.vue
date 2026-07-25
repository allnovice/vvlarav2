<script setup>
const props = defineProps({
    label: {
        type: String,
        required: true,
    },

    oldValue: {
        type: [String, Number, Boolean, null],
        default: null,
    },

    newValue: {
        type: [String, Number, Boolean, null],
        default: null,
    },
})

const display = (value) => {
    return value === null || value === undefined || value === ''
        ? '—'
        : value
}
</script>

<template>
    <div>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            {{ label }}
        </p>

        <template v-if="oldValue === null || oldValue === undefined">
            <p class="text-gray-900 dark:text-gray-100">
                {{ display(newValue) }}
            </p>
            <p class="text-xs italic text-green-600">
                (new)
            </p>
        </template>

        <template v-else-if="oldValue !== newValue">
            <p class="text-gray-900 dark:text-gray-100">
                {{ display(oldValue) }} → {{ display(newValue) }}
            </p>
        </template>

        <template v-else>
            <p class="text-gray-900 dark:text-gray-100">
                {{ display(oldValue) }}
            </p>
            <p class="text-xs italic text-gray-500">
                (unchanged)
            </p>
        </template>
    </div>
</template>
