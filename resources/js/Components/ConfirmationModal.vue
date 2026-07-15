<script setup>
import Modal from '@/Components/Modal.vue'

defineProps({
    show: Boolean,
    title: String,
    message: String,
    confirmText: {
        type: String,
        default: 'Confirm',
    },
})

const emit = defineEmits([
    'close',
    'confirm',
])
</script>

<template>
    <Modal
        :show="show"
        max-width="md"
        @close="$emit('close')"
    >
        <div class="p-6">

            <h2 class="text-lg font-semibold text-gray-900">
                {{ title }}
            </h2>

            <p class="mt-3 text-sm text-gray-600">
                {{ message }}
            </p>

            <div class="mt-6 flex justify-end gap-3">

                <button
                    @click="$emit('close')"
                    class="rounded-lg border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-100"
                >
                    Cancel
                </button>

                <button
                    @click="$emit('confirm')"
                    class="rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
                >
                    {{ confirmText }}
                </button>

            </div>

        </div>
    </Modal>
</template>
