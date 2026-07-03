<script setup>

defineProps({
    value: String,
})

</script>

<template>

<span
    class="inline-flex items-center
           px-3 py-1
           rounded-full
           bg-gray-100
           text-gray-700
           text-sm
           font-medium"
>
    {{ value }}
</span>

</template>

