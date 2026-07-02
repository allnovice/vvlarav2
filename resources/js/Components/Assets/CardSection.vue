<script setup>

defineProps({
    title: String,
})

</script>

<template>

<div class="mt-8">

    <h3 class="text-lg font-semibold text-gray-800">
        {{ title }}
    </h3>

    <div class="mt-4 border rounded-lg overflow-hidden">

        <slot />

    </div>

</div>

</template>
