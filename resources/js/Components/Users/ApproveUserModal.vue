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
        <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-xl dark:bg-gray-800">
        
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            
                Approve User
            </h2>
 
            <p class="mt-2 text-gray-600 dark:text-gray-300">
           
                Approve {{ props.user?.name }}?
            </p>

            <div class="mt-6 flex justify-end gap-2">
<button
    @click="emit('close')"
    
    class="rounded border border-gray-300 bg-white px-4 py-2 text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600"
>
    Cancel
</button>
<button
    @click="approveUser"
    
    class="rounded bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
>
    Approve
</button>
            </div>
        </div>
    </div>
</template>
