<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },

    disabled: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <button
        :type="type"
        :disabled="disabled"
        class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-white active:bg-red-700 disabled:cursor-not-allowed disabled:opacity-25 dark:bg-red-600 dark:hover:bg-red-500 dark:active:bg-red-700 dark:focus:ring-offset-gray-800"
    >
        <slot />
    </button>
</template>
