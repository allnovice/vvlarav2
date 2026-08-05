<script setup>
defineProps({
    title: String,
})
</script>

<template>

<div class="space-y-6">

    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
        {{ title }}
    </h2>

    <slot />

</div>

</template>
