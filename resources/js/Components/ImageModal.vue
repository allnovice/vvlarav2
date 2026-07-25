<script setup>
import { ref } from 'vue'
import { CubeIcon } from '@heroicons/vue/24/outline'

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
    thumbnailSrc: {
        type: String,
        default: null,
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

<div
    v-if="src"
    @click="show = true"
>
    <img
        :src="thumbnailSrc ?? src"
        :alt="alt"
        :class="[
            'block cursor-pointer',
            imageFit,
            thumbnailClass,
        ]"
        @load="onImageLoad"
    />
</div>



<div
    v-else
    :class="[
        'flex flex-col items-center justify-center rounded-xl border bg-gray-100 dark:border-gray-700 dark:bg-gray-800',
        thumbnailClass,
    ]"
>
    <CubeIcon class="h-10 w-10 text-gray-400 dark:text-gray-500" />

    <span class="mt-2 text-xs text-gray-500 dark:text-gray-400">
        No Photo
    </span>

    <span class="mt-1 text-lg">
        ¯\_(ツ)_/¯
    </span>
</div>




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
