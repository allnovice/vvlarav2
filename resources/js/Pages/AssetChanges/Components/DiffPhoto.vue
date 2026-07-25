<script setup>
import ImageModal from '@/Components/ImageModal.vue'

const props = defineProps({
    oldPhoto: {
        type: String,
        default: null,
    },

    newPhoto: {
        type: String,
        default: null,
    },
})
</script>

<template>
    <div>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Photo
        </p>

        <template v-if="!oldPhoto">

<ImageModal
    v-if="newPhoto"
    :src="`/storage/${newPhoto}`"
    alt="New Photo"
    thumbnail-class="w-32 h-32 rounded-xl object-cover shadow-sm border"
/>


            <p class="text-xs italic text-green-600 mt-2">
                (new)
            </p>
        </template>

        <template v-else-if="oldPhoto !== newPhoto">
            <div class="flex items-center gap-4">
                <ImageModal
                    :src="`/storage/${oldPhoto}`"
                    alt="Current Photo"
                    thumbnail-class="w-32 h-32 rounded-xl object-cover shadow-sm border"
                />

                <span class="text-xl">→</span>


<ImageModal
    v-if="newPhoto"
    :src="`/storage/${newPhoto}`"
    alt="Proposed Photo"
    thumbnail-class="w-32 h-32 rounded-xl object-cover shadow-sm border"
/>

            </div>
        </template>

        <template v-else>
            <ImageModal
                :src="`/storage/${oldPhoto}`"
                alt="Asset Photo"
                thumbnail-class="w-32 h-32 rounded-xl object-cover shadow-sm border"
            />
            <p class="text-xs italic text-gray-500 mt-2">
                (unchanged)
            </p>
        </template>
    </div>
</template>
