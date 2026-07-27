<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import Toast from '@/Components/Toast.vue';
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 transition-colors dark:bg-gray-900 sm:justify-center sm:pt-0"
    >
 <Toast />
        <div>
            <Link href="/">
                <ApplicationLogo class="h-20 w-20 fill-current text-gray-500 dark:text-gray-300" />
            </Link>
        </div>

        <div
            class="mt-6 w-full overflow-hidden rounded-lg bg-white px-6 py-4 shadow-md dark:bg-gray-800 sm:max-w-md"
        >
            <slot />
        </div>
    </div>
</template>
