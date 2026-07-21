<script setup>
defineProps({
    title: String,
})
</script>

<template>
    <div class="h-full w-full rounded-lg border border-gray-200 bg-white p-6 shadow-sm">    
    
        <h2
            v-if="title"
            class="mb-4 text-lg font-semibold"
        >
            {{ title }}
        </h2>

        <slot />
    </div>
</template>
