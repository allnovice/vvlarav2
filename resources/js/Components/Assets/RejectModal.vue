<script setup>
import Modal from '@/Components/Modal.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'

defineProps({
    show: Boolean,
    form: Object,
})

const emit = defineEmits([
    'close',
    'submit',
])
</script>

<template>

<Modal
    :show="show"
    @close="emit('close')"
>

<div class="p-6">

<h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
    Reject Verification
</h2>

<p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
    Please provide a reason for rejecting this verification request.
</p>

<div
    v-if="form.errors.verification"
    class="mt-4 rounded border border-red-300 bg-red-50 p-3 text-sm text-red-700 dark:border-red-700 dark:bg-red-900/40 dark:text-red-300"
>
    {{ form.errors.verification }}
</div>

<div class="mt-6">

<label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
    Reviewer Remarks
</label>

<textarea
    v-model="form.reviewer_remarks"
    rows="5"
    class="w-full rounded-md border-gray-300 bg-white text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
/>

</div>

<div class="mt-6 flex justify-end gap-3">

<SecondaryButton
    @click="emit('close')"
>
    Cancel
</SecondaryButton>

<PrimaryButton
    @click="emit('submit')"
>
    Reject
</PrimaryButton>

</div>

</div>

</Modal>

</template>
