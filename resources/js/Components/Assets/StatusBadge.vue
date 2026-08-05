<script setup>
const props = defineProps({
    status: String,
    clickable: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits([
    'click',
])
</script>

<template>

    <span
        @click="clickable && emit('click')"
        :class="[
            'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold',
            clickable ? 'cursor-pointer transition hover:opacity-80' : '',

            status === 'Active'
                ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300'
                : status === 'Maintenance'
                ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300'
                : status === 'Retired'
                ? 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300'

                : status === 'Verified'
                ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300'

                : status === 'Pending Verification'
                ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300'

                : status === 'Not Verified'
                ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300'

                : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300'
        ]"
    >
        {{ status }}
    </span>

</template>