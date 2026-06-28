<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineProps({
    assets: Array,
})

const showModal = ref(false)

const form = useForm({
    property_number: '',
    type: '',
    description: '',
})

const submit = () => {
    form.post(route('assets.store'), {
        onSuccess: () => {
            form.reset()
            showModal.value = false
        },
    })
}
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Assets
                </h2>

                <button
                    @click="showModal = true"
                    class="px-4 py-2 bg-blue-600 text-white rounded"
                >
                    Add Asset
                </button>
            </div>
        </template>

        <div class="py-6 px-6">

            <div class="bg-white shadow rounded p-4">

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left p-2">Property No.</th>
                            <th class="text-left p-2">Type</th>
                            <th class="text-left p-2">Description</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="asset in assets"
                            :key="asset.id"
                            class="border-b"
                        >
                            <td class="p-2">
                                {{ asset.property_number }}
                            </td>

                            <td class="p-2">
                                {{ asset.type }}
                            </td>

                            <td class="p-2">
                                {{ asset.description }}
                            </td>
                        </tr>

                        <tr v-if="assets.length === 0">
                            <td colspan="3" class="p-4 text-center">
                                No assets found
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

            <!-- Modal -->
            <div
                v-if="showModal"
                class="fixed inset-0 flex items-center justify-center bg-black/50"
            >
                <div class="bg-white p-6 rounded shadow w-96">

                    <h3 class="text-lg font-bold mb-4">
                        Add Asset
                    </h3>

                    <div class="mb-3">
                        <input
                            v-model="form.property_number"
                            placeholder="Property Number"
                            class="w-full border rounded p-2"
                        />
                    </div>

                    <div class="mb-3">
                        <input
                            v-model="form.type"
                            placeholder="Type"
                            class="w-full border rounded p-2"
                        />
                    </div>

                    <div class="mb-3">
                        <textarea
                            v-model="form.description"
                            placeholder="Description"
                            class="w-full border rounded p-2"
                        />
                    </div>

                    <div class="flex justify-end gap-2">
                        <button
                            @click="showModal = false"
                            class="px-4 py-2 border rounded"
                        >
                            Cancel
                        </button>

                        <button
                            @click="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded"
                        >
                            Save
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
