<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    show: Boolean,
    asset: Object,
})

const emit = defineEmits([
    'close',
])
const form = useForm({
    maintenance_date: '',
    frequency: '',
    custom_interval: null,
    notes: '',
})
function saveSchedule() {
console.log(route('maintenance-schedule.store', props.asset.id))
    form.post(route('maintenance-schedule.store', props.asset.id), {
        onSuccess: () => {
            emit('close')
        },
    })
}
</script>

<template>

<div
    v-if="show"
    class="fixed inset-0 flex items-center justify-center bg-black/50"
>
    <div class="w-full max-w-lg rounded-lg bg-white p-6">

        <h2 class="mb-4 text-xl font-semibold">
            Assign Schedule
        </h2>

        <p class="mb-4">
            {{ asset?.property_number }}
        </p>

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

<label class="block mt-4 mb-2">
    Maintenance Date
</label>

<input
    v-model="form.maintenance_date"
    type="date"
    class="w-full rounded border p-2"
/>

        <div class="mt-4 flex gap-2">
            <button @click="emit('close')">
                Cancel
            </button>

<button @click="saveSchedule">
    Save
</button>

        </div>

    </div>
</div>

</template>
