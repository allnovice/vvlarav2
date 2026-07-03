<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    show: Boolean,
    asset: Object,
})

const emit = defineEmits(['close'])

const form = useForm({
    type: 'maintenance',
    title: '',
    description: '',
    performed_at: '',
    remarks: '',
})
const submit = () => {
    form.post(route('assets.history.store', props.asset.id), {
        onSuccess: () => {
            form.reset()
            emit('close')
        },
    })
}
</script>

<template>
<div
    v-if="show"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    @click.self="emit('close')"
>

        <div class="w-full max-w-lg rounded-xl bg-white p-6">

            <h2 class="mb-6 text-xl font-semibold">
                Add History
            </h2>
<h2 class="mb-6 text-xl font-semibold">
    Add History
</h2>

<pre class="mb-4 rounded bg-red-50 p-2 text-sm text-red-600">
{{ form.errors }}
</pre>


<form
    @submit.prevent="submit"
    class="space-y-4"
>

    <div>
        <label class="block text-sm font-medium mb-1">
            Type
        </label>

        <select
            v-model="form.type"
            class="w-full rounded-lg border-gray-300"
        >
            <option value="maintenance">Maintenance</option>
            <option value="repair">Repair</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">
            Title
        </label>

        <input
            v-model="form.title"
            type="text"
            class="w-full rounded-lg border-gray-300"
        >
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">
            Description
        </label>

        <textarea
            v-model="form.description"
            rows="3"
            class="w-full rounded-lg border-gray-300"
        />
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">
            Performed Date
        </label>

        <input
            v-model="form.performed_at"
            type="date"
            class="w-full rounded-lg border-gray-300"
        >
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">
            Remarks
        </label>

        <textarea
            v-model="form.remarks"
            rows="2"
            class="w-full rounded-lg border-gray-300"
        />
    </div>
<div class="flex justify-end gap-3 pt-4">

    <button
        type="button"
        @click="emit('close')"
        class="rounded-lg border px-4 py-2 hover:bg-gray-50"
    >
        Cancel
    </button>

    <button
        type="submit"
        :disabled="form.processing"
        class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 disabled:opacity-50"
    >
        {{ form.processing ? 'Saving...' : 'Save History' }}
    </button>

</div>
</form>


        </div>
    </div>
</template>
