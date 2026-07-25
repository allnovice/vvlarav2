
<script setup>
import { computed, ref, watch } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()

const success = computed(() => page.props.flash?.success)
const error = computed(() => page.props.flash?.error)

const showSuccess = ref(false)
const showError = ref(false)

watch(success, (value) => {
    if (!value) return

    showSuccess.value = true

    setTimeout(() => {
        showSuccess.value = false
    }, 4000)
}, { immediate: true })

watch(error, (value) => {
    if (!value) return

    showError.value = true

    setTimeout(() => {
        showError.value = false
    }, 4000)
}, { immediate: true })
</script>

<template>
<Transition name="fade">
    <div
        v-if="showSuccess"
        class="fixed top-4 right-4 z-50 rounded-lg bg-green-600 px-4 py-3 text-white shadow-lg"
    >
        {{ success }}
    </div>
</Transition>
<Transition name="fade">
    <div
        v-if="showError"
        class="fixed top-4 right-4 z-50 rounded-lg bg-red-600 px-4 py-3 text-white shadow-lg"
    >
        {{ error }}
    </div>
</Transition>
</template>
<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: all 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
</style>
