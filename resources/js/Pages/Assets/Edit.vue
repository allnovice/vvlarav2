<script setup>
import { Link, useForm } from '@inertiajs/vue3'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'

const props = defineProps({
    asset: Object,
})

const form = useForm({
    property_number: props.asset.property_number,
    type: props.asset.type,
    status: props.asset.status,
    description: props.asset.description,
})

const submit = () => {
    form.put(route('assets.update', props.asset.id))
}
</script>

<template>

    <AuthenticatedLayout>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Asset
            </h2>
        </template>

        <div class="py-6 px-6">

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-3xl">

                <div class="mb-6">

                    <Link
                        :href="route('assets.show', asset.id)"
                        class="text-blue-600 hover:underline"
                    >
                        ← Back to Asset Details
                    </Link>

                </div>

                <form @submit.prevent="submit">

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
                            class="mt-2"
                            :message="form.errors.property_number"
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
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
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
                            class="mt-2"
                            :message="form.errors.type"
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
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                            <option>Active</option>
                            <option>Under Repair</option>
                            <option>Borrowed</option>
                            <option>Archived</option>
                        </select>

                        <InputError
                            class="mt-2"
                            :message="form.errors.status"
                        />

                    </div>

                    <div class="mb-6">

                        <InputLabel
                            for="description"
                            value="Description"
                        />

                        <textarea
                            id="description"
                            v-model="form.description"
                            rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        ></textarea>

                        <InputError
                            class="mt-2"
                            :message="form.errors.description"
                        />

                    </div>

                    <div class="flex justify-end gap-2">

                        <Link
                            :href="route('assets.show', asset.id)"
                        >
                            <SecondaryButton>
                                Cancel
                            </SecondaryButton>
                        </Link>

                        <PrimaryButton
                            :disabled="form.processing"
                        >
                            Save Changes
                        </PrimaryButton>

                    </div>

                </form>

            </div>

        </div>

    </AuthenticatedLayout>

</template>
