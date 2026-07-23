<script setup>
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'

defineProps({
    form: Object,
})
</script>

<template>

    <h4 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">
        Asset Information
    </h4>

    <div class="mb-4">
        <InputLabel
            for="property_number"
            value="Property Number"
        />

        <TextInput
            id="property_number"
            v-model="form.property_number"
            class="mt-1 block w-full"
        />

        <InputError
            :message="form.errors.property_number"
            class="mt-2"
        />
    </div>

    <div class="mb-4">
        <InputLabel
            for="type"
            value="Type"
        />

        <select
            id="type"
            v-model="form.type"
            class="mt-1 block w-full rounded-md border-gray-300 bg-white text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
        >
            <option value="">Select Type</option>
            <option>Laptop</option>
            <option>Desktop</option>
            <option>Monitor</option>
            <option>Printer</option>
            <option>Scanner</option>
            <option>Server</option>
            <option>Network Device</option>
            <option>UPS</option>
            <option>Furniture</option>
            <option>Other</option>
        </select>

        <InputError
            :message="form.errors.type"
            class="mt-2"
        />
    </div>

    <div class="mb-4">
        <InputLabel
            for="status"
            value="Status"
        />

        <select
            id="status"
            v-model="form.status"
            class="mt-1 block w-full rounded-md border-gray-300 bg-white text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
        >
            <option value="Active">Active</option>
            <option value="Under Repair">Under Repair</option>
            <option value="Borrowed">Borrowed</option>
            <option value="Archived">Archived</option>
        </select>

        <InputError
            :message="form.errors.status"
            class="mt-2"
        />
    </div>

    <div class="mb-4">
        <InputLabel
            for="description"
            value="Description"
        />

        <textarea
            id="description"
            v-model="form.description"
            rows="4"
            class="mt-1 block w-full rounded-md border-gray-300 bg-white text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
        ></textarea>

        <InputError
            :message="form.errors.description"
            class="mt-2"
        />
    </div>

</template>
