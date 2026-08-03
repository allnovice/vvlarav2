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
        
        <div class="w-full max-w-lg rounded-lg bg-white p-6 dark:bg-gray-800">
            <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-gray-100">
                Perform Maintenance
            </h2>

<p class="text-gray-900 dark:text-gray-100">
    {{ asset?.property_number }}
</p>

<div v-if="!asset.next_due_date">
<label class="mb-2 block text-gray-700 dark:text-gray-300">
    Frequency
</label>

<select
    v-model="form.frequency"
    class="w-full rounded border border-gray-300 bg-white p-2 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
>
    <option value="">Select frequency</option>
    <option>Weekly</option>
    <option>Monthly</option>
    <option>Quarterly</option>
    <option>Semi-Annual</option>
    <option>Annual</option>
    <option>Custom</option>
</select>
<p
    v-if="form.errors.frequency"
    class="mt-1 text-sm text-red-600"
>
    {{ form.errors.frequency }}
</p>
</div>

<div class="mt-4">
    <label class="mb-2 block text-gray-700 dark:text-gray-300">
        Remarks
    </label>

    <textarea
        v-model="form.remarks"
        rows="3"
        class="w-full rounded border border-gray-300 bg-white p-2 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
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
        class="rounded bg-gray-200 px-4 py-2 text-gray-900 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600"
    >
        Add Photos
    </button>

    <p
        
        v-if="form.photos?.length"
        class="mt-2 text-sm text-gray-600 dark:text-gray-400"
    >
        {{ form.photos.length }} photo(s) selected
    </p>
<p
    v-if="form.errors.photos"
    class="mt-1 text-sm text-red-600"
>
    {{ form.errors.photos }}
</p>

<p
    v-if="form.errors['photos.0']"
    class="mt-1 text-sm text-red-600"
>
    {{ form.errors['photos.0'] }}
</p>
</div>



<button
    @click="emit('close')"
    class="mr-3 rounded border border-gray-300 bg-white px-4 py-2 text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600"
>
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
