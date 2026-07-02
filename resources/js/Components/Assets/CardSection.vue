<script setup>
defineProps({
    title: String,
    icon: {
        type: Object,
        default: null,
    },
})
</script>

<template>

<div class="mt-8">

    


<h3 class="flex items-center gap-2 text-lg font-semibold text-gray-800">

    <component
        v-if="icon"
        :is="icon"
        class="w-5 h-5 text-blue-600"
    />

    {{ title }}

</h3>





    <div class="mt-4 border rounded-lg overflow-hidden">

        <slot />

    </div>

</div>

</template>
