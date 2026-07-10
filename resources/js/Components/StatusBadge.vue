<script setup>
defineProps({
    status: String,
})
</script>

<template>
    <span
        class="inline-block px-3 py-1 rounded-full text-sm capitalize"
        :class="{
            'bg-yellow-100 text-yellow-800': status === 'pending',
            'bg-green-100 text-green-800': status === 'approved',
            'bg-red-100 text-red-800': status === 'rejected',
        }"
    >
        {{ status }}
    </span>
</template>
