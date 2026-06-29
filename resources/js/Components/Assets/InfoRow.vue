<script setup>
defineProps({
    label: String,
    value: [String, Number],
})
</script>

<template>
    <div class="grid grid-cols-3 gap-4 border-b py-3 px-4">

        <div class="font-medium text-gray-600">
            {{ label }}
        </div>

        <div class="col-span-2">
            <slot>
                {{ value || '-' }}
            </slot>
        </div>
    </div>
    
</template>
