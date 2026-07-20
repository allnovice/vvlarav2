<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import ImageModal from '@/Components/ImageModal.vue'

const editingPhotoId = ref(null)
const editedCaption = ref('')
const captionForm = useForm({
    caption: '',
})
const form = useForm({
    photos: [],
})
const props = defineProps({
    assetId: {
        type: Number,
        required: true,
    },
    photos: {
        type: Array,
        default: () => [],
    },
})
const fileInput = ref(null)
function openFilePicker() {
    fileInput.value?.click()
}
function handleFiles(event) {
    const files = Array.from(event.target.files)

    if (!files.length) {
        return
    }

    form.photos = files

    form.post(route('assets.photos.store', props.assetId), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
            event.target.value = ''
        },
    })
}
function startEditing(photo) {
    editingPhotoId.value = photo.id
    editedCaption.value = photo.caption ?? ''
}

function cancelEditing() {
    editingPhotoId.value = null
    editedCaption.value = ''
}
function submitCaption(photo) {
    captionForm.caption = editedCaption.value

    captionForm.post(
        route('assets.photos.caption', photo.id),
        {
            preserveScroll: true,
            onSuccess: () => {
                cancelEditing()
            },
        }
    )
}
function requestDelete(photo) {
    if (!confirm('Submit this photo for deletion?')) {
        return
    }

    router.post(
        route('assets.photos.delete', photo.id),
        {},
        {
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold">
                Additional Photos
            </h2>

            <button
                @click="openFilePicker"
                class="px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
            >
                Add Photos
            </button>
        </div>

        <input
            ref="fileInput"
            type="file"
            multiple
            accept="image/*"
            class="hidden"
            @change="handleFiles"
        />

        <div v-if="photos.length === 0" class="text-sm text-gray-500">
            No additional photos available.
        </div>


<div v-else>
    <p class="text-sm text-gray-500 mb-4">
        {{ photos.length }} photo(s)
    </p>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <div
            v-for="photo in photos"
            :key="photo.id"
            class="border rounded-lg p-2"
        >
            <div class="relative">


             
<ImageModal
    :src="`/storage/${photo.photo_path}`"
    alt="Additional Photo"
    thumbnail-class="w-full h-32 rounded"
/>

<button
    type="button"
    :disabled="photo.has_pending_request"
    class="absolute top-2 right-2 flex h-7 w-7 items-center justify-center rounded-full bg-white/90 text-red-600 shadow transition disabled:cursor-not-allowed disabled:opacity-50 hover:bg-red-600 hover:text-white"
    @click="requestDelete(photo)"
>
    ✕
</button>



            </div>

            <div v-if="editingPhotoId === photo.id">
                <input
                    v-model="editedCaption"
                    class="mt-2 w-full rounded-md border-gray-300 shadow-sm"
                    @keyup.enter="submitCaption(photo)"
                    @keyup.esc="cancelEditing"
                />

                <p class="mt-2 text-xs text-gray-500">
                    Press Enter to submit • Esc to cancel
                </p>
            </div>

            <div v-else>




                <p
                    v-if="photo.caption"
                    class="mt-2 text-xs text-gray-600"
                >
                    {{ photo.caption }}
                </p>


<button
    :disabled="photo.has_pending_request"    
    class="mt-2 text-sm text-blue-600 hover:underline disabled:text-gray-400 disabled:no-underline disabled:cursor-not-allowed"
    @click="startEditing(photo)"
>
    Edit Caption
</button>




            </div>
        </div>
    </div>
</diV>

 
    </div>
</template>
