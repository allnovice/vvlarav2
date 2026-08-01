<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

const fileInput = ref(null)
const props = defineProps({
    show: Boolean,
    asset: Object,
})
const emit = defineEmits(['close'])

const form = useForm({
    frequency: '',
    remarks: '',
    photos: [],
})
function performMaintenance() {
    console.log(form.photos)
    console.log(form.data())
    form.post(route('maintenance.perform', props.asset.id), {
        forceFormData: true,
        onSuccess: () => {
            emit('close')
            form.reset()
        },
    })
}
function openFilePicker() {
    fileInput.value?.click()
}
function handleFiles(event) {
    const files = Array.from(event.target.files)

    if (!files.length) return

    form.photos = files
}
</script>

<template>
    <div
        v-if="show"
        class="fixed inset-0 flex items-center justify-center bg-black/50"
    >
        <div class="w-full max-w-lg rounded-lg bg-white p-6">

            <h2 class="mb-4 text-xl font-semibold">
                Perform Maintenance
            </h2>

            <p>{{ asset?.property_number }}</p>

<div v-if="!asset.next_due_date">
<label class="block mb-2">
    Frequency
</label>

<select
    v-model="form.frequency"
    class="w-full rounded border p-2"
>
    <option value="">Select frequency</option>
    <option>Weekly</option>
    <option>Monthly</option>
    <option>Quarterly</option>
    <option>Semi-Annual</option>
    <option>Annual</option>
    <option>Custom</option>
</select>
</div>

<div class="mt-4">
    <label class="mb-2 block">
        Remarks
    </label>

    <textarea
        v-model="form.remarks"
        rows="3"
        class="w-full rounded border p-2"
        placeholder="Enter maintenance remarks..."
    />
</div>



<input
    ref="fileInput"
    type="file"
    multiple
    accept="image/*"
    class="hidden"
    @change="handleFiles"
/>

<div class="mt-4">
    <button
        type="button"
        @click="openFilePicker"
        class="rounded bg-gray-200 px-4 py-2 hover:bg-gray-300"
    >
        Add Photos
    </button>

    <p
        
        v-if="form.photos?.length"
        class="mt-2 text-sm text-gray-600"
    >
        {{ form.photos.length }} photo(s) selected
    </p>
</div>



            <button @click="emit('close')">
                Close
            </button>

<button
    class="rounded bg-green-600 px-4 py-2 text-white"
    @click="performMaintenance"
>
    Save
</button>

        </div>
    </div>
</template>
