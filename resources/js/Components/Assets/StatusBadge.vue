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
                ? 'bg-green-100 text-green-700'
                : status === 'Maintenance'
                ? 'bg-yellow-100 text-yellow-700'
                : status === 'Retired'
                ? 'bg-red-100 text-red-700'
                : 'bg-gray-100 text-gray-700'
        ]"
    >
        {{ status }}
    </span>

</template>
