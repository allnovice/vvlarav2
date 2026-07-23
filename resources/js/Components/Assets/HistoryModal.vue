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
    <div class="w-full max-w-lg rounded-xl bg-white p-6 dark:bg-gray-800">

        <h2 class="mb-6 text-xl font-semibold text-gray-900 dark:text-gray-100">
            Add History
        </h2>

        <form
            @submit.prevent="submit"
            class="space-y-4"
        >

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Type
                </label>

                <select
                    v-model="form.type"
                    class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
                >
                    <option value="maintenance">Maintenance</option>
                    <option value="repair">Repair</option>
                </select>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Title
                </label>

                <input
                    v-model="form.title"
                    type="text"
                    class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
                >
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Description
                </label>

                <textarea
                    v-model="form.description"
                    rows="3"
                    class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
                ></textarea>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Performed Date
                </label>

                <input
                    v-model="form.performed_at"
                    type="date"
                    class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
                >
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Remarks
                </label>

                <textarea
                    v-model="form.remarks"
                    rows="2"
                    class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
                ></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4">

                <button
                    type="button"
                    @click="emit('close')"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600"
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
