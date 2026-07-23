<script setup>

defineProps({
    value: String,
})

</script>

<template>

<span
class="inline-flex items-center
       rounded-full
       bg-gray-100
       px-3 py-1
       text-sm
       font-medium
       text-gray-700
       dark:bg-gray-700
       dark:text-gray-200"
>
    {{ value }}
</span>

</template>

