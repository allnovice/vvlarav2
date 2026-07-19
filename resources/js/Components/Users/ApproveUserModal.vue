<script setup>
import { router } from '@inertiajs/vue3';

const emit = defineEmits(['close']);
const props = defineProps({
    show: Boolean,
    user: Object,
});

function approveUser() {
    router.post(
        route('users.approve', props.user.id),
        {},
        {
            onSuccess: () => {
                emit('close');
            },
        }
    );
}
</script>

<template>
    <div
        v-if="props.show"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    >
        <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-xl">
            <h2 class="text-lg font-semibold">
                Approve User
            </h2>

            <p class="mt-2 text-gray-600">
                Approve {{ props.user?.name }}?
            </p>

            <div class="mt-6 flex justify-end gap-2">
<button
    @click="emit('close')"
    class="rounded border px-4 py-2"
>
    Cancel
</button>
<button
    @click="approveUser"
    class="rounded bg-indigo-600 px-4 py-2 text-white"
>
    Approve
</button>
            </div>
        </div>
    </div>
</template>
