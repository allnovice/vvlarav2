<script setup>
defineProps({
    title: String,
})
</script>

<template>
    
<div class="h-full w-full rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">    
        <h2
            v-if="title"
            class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100"
        >
            {{ title }}
        </h2>

        <slot />
    </div>
</template>
