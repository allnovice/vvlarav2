<script setup>
defineProps({
    title: String,
    icon: [Object, Function],
})
</script>

<template>

<div class="mt-8">

    


<h3 class="flex items-center gap-2 text-lg font-semibold text-gray-800 dark:text-gray-100">

    <component
        v-if="icon"
        :is="icon"
        class="h-5 w-5 text-blue-600 dark:text-blue-400"
    />

    {{ title }}

</h3>





    <div class="mt-4 overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">

        <slot />

    </div>

</div>

</template>
