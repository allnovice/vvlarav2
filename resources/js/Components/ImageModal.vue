<script setup>
import { ref } from 'vue'

const props = defineProps({
    src: {
        type: String,
        required: true,
    },
    alt: {
        type: String,
        default: 'Image',
    },
    thumbnailClass: {
        type: String,
        default: '',
    },
})

const show = ref(false)
const imageFit = ref('object-cover')

function onImageLoad(event) {
    const img = event.target

    if (img.naturalHeight > img.naturalWidth) {
        imageFit.value = 'object-contain'
    } else {
        imageFit.value = 'object-cover'
    }
}
</script>
<template>
    <img
        :src="src"
        :alt="alt"
        :class="[
            'block cursor-pointer',
            imageFit,
            thumbnailClass,
        ]"
        @load="onImageLoad"
        @click="show = true"
    />

    <div
        v-if="show"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4"
        @click="show = false"
    >
<img
    :src="src"
    :alt="alt"
    class="max-w-full max-h-full object-contain rounded-lg cursor-zoom-out"
    @click="show = false"
/>
    </div>
</template>
