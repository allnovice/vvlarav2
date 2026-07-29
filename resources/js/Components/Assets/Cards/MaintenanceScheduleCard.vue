<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const editing = ref(false)
const props = defineProps({
    asset: Object,
})
const form = useForm({
    maintenance_date: '',
    frequency: '',
    custom_interval: null,
    next_due_date: '',
    notes: '',
})
const hasSchedule = !!props.asset.maintenance_schedule
const schedule = props.asset.maintenance_schedule

if (schedule) {
    form.maintenance_date = schedule.maintenance_date
    form.frequency = schedule.frequency
    form.custom_interval = schedule.custom_interval
    form.notes = schedule.notes
}
function saveSchedule() {
    if (props.asset.maintenance_schedule) {
        form.put(route('maintenance-schedule.update', props.asset.id), {
            onSuccess: () => {
                editing.value = false
            },
        })
    } else {
        form.post(route('maintenance-schedule.store', props.asset.id))
    }
}
function deleteSchedule() {
    if (!confirm('Are you sure you want to delete this maintenance schedule?')) {
        return
    }

    form.delete(route('maintenance-schedule.destroy', props.asset.id))
}
</script>
<template>
    <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-800">

        <h3 class="mb-6 text-lg font-semibold text-gray-900 dark:text-gray-100">
            Maintenance Schedule
        </h3>

        <div v-if="!asset.maintenance_schedule || editing">

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Frequency
                    </label>

                    <select
                        v-model="form.frequency"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >
                        <option value="">Select frequency</option>
                        <option value="Weekly">Weekly</option>
                        <option value="Monthly">Monthly</option>
                        <option value="Quarterly">Quarterly</option>
                        <option value="Semi-Annual">Semi-Annual</option>
                        <option value="Annual">Annual</option>
                        <option value="Custom">Custom</option>
                    </select>
                </div>

                <div v-if="form.frequency === 'Custom'">
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Custom Interval (days)
                    </label>

                    <input
                        v-model="form.custom_interval"
                        type="number"
                        min="1"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Maintenance Date
                    </label>

                    <input
                        v-model="form.maintenance_date"
                        type="date"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Notes
                    </label>

                    <textarea
                        v-model="form.notes"
                        rows="3"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    ></textarea>
                </div>

            </div>

            <div class="mt-6">
                <button
                    type="button"
                    @click="saveSchedule"
                    class="rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
                >
                    Save Schedule
                </button>
            </div>

        </div>

        <div
            v-else
            class="space-y-4 rounded-lg border border-gray-200 p-4 dark:border-gray-700"
        >
            <div>
                <p class="text-sm text-gray-500">Maintenance Date</p>
                <p>{{ asset.maintenance_schedule.maintenance_date }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Frequency</p>
                <p>{{ asset.maintenance_schedule.frequency }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Next Due</p>
                <p>{{ asset.maintenance_schedule.next_due_date }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Notes</p>
                <p>{{ asset.maintenance_schedule.notes || '-' }}</p>
            </div>

            <div class="flex gap-2 pt-2">
                <button
                    type="button"
                    @click="editing = true"
                    class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
                >
                    Edit Schedule
                </button>

                <button
                    type="button"
                    @click="deleteSchedule"
                    class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700"
                >
                    Delete Schedule
                </button>
            </div>

        </div>

    </div>
</template>
