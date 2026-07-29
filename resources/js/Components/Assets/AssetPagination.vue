<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    links: Array,
})
</script>

<template>
    <div class="flex flex-wrap items-center justify-center gap-1 p-4">
        <Link
            v-for="link in links"
            :key="link.label"
            :href="link.url ?? ''"
            v-html="link.label"
            class="px-3 py-2 rounded-md border text-sm"
            :class="[
                link.active
                    ? 'bg-blue-600 text-white'
                    : 'bg-white text-gray-700 hover:bg-gray-100',
                !link.url && 'opacity-50 pointer-events-none'
            ]"
        />
    </div>
</template>
