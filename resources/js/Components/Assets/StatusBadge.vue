<script setup>
defineProps({
    status: String,
})
</script>

<template>

    <span




:class="[
    'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold',
    status === 'Active'
        ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300'
        : status === 'Maintenance'
        ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300'
        : status === 'Retired'
        ? 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300'
        : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300'
]"



    >
        {{ status }}
    </span>

</template>
