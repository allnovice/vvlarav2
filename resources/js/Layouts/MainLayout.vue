<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import Toast from '@/Components/Toast.vue';

defineProps({
    title: String,
})
const showingNavigationDropdown = ref(false);
const approvalsOpen = ref(false)
const approvalsMenu = ref(null)
const mobileApprovalsOpen = ref(false)
const page = usePage();
const isAdmin = computed(() => user.value?.role === 'admin');
const user = computed(() => page.props.auth?.user ?? null);
const mainLinks = [
    {
        label: 'Dashboard',
        route: 'dashboard',
        active: 'home',
    },
    {
        label: 'Assets',
        route: 'assets',
        active: 'assets',
    },
    {
        label: 'Users',
        route: 'users.index',
        active: 'users.*',
    },
]
const approvalLinks = [
    {
        label: 'Asset Change Requests',
        route: 'asset-changes.index',
        active: 'asset-changes.*',
    },
    {
        label: 'Photo Upload Requests',
        route: 'asset-photo-changes.index',
        active: 'asset-photo-changes.*',
    },
    {
        label: 'History Change Requests',
        route: 'asset-history-changes.index',
        active: 'asset-history-changes.*',
    },
    {
        label: 'Verification Requests',
        route: 'asset-verifications.index',
        active: 'asset-verifications.*',
    },
]
const approvalsActive = computed(() =>
    route().current('asset-changes.*') ||
    route().current('asset-photo-changes.*') ||
    route().current('asset-history-changes.*') ||
    route().current('asset-verifications.*')
)
const handleClickOutside = (event) => {
    if (
        approvalsMenu.value &&
        !approvalsMenu.value.contains(event.target)
    ) {
        approvalsOpen.value = false
    }
}
onMounted(() => {
    document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside)
})
</script>

<template>

    <div class="min-h-screen bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100">
<Toast />
        <nav class="sticky top-0 z-50 border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
            <div class="mx-auto max-full px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">

                    <!-- Left -->
                    <div class="flex">

                        <div class="flex shrink-0 items-center">
                            <Link href="/">
                                <img
                                    src="/images/logo.png"
                                    alt="CMMS"
                                    class="h-10 w-10 rounded-full object-cover"
                                />
                            </Link>
                        </div>

                        <div class="hidden sm:ms-10 sm:flex sm:space-x-8">

<NavLink
    v-for="link in mainLinks"
    :key="link.route"
    :href="route(link.route)"
    :active="route().current(link.active)"
>
    {{ link.label }}
</NavLink>

<div ref="approvalsMenu" class="relative">
    <button
        type="button"
        @click="approvalsOpen = !approvalsOpen"
        :class="[
    'inline-flex h-full items-center border-b-2 px-1 pt-1 text-sm font-medium transition',
    approvalsActive
        ? 'border-indigo-400 text-gray-900 dark:text-white'
        : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-white'
]"
    >
        Approvals
        <span class="ml-1">
            {{ approvalsOpen ? '▲' : '▼' }}
        </span>
    </button>

    <div
        v-if="approvalsOpen"
        class="absolute left-0 z-50 mt-2 w-64 rounded-md border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800"
    >



<Link
    v-for="link in approvalLinks"
    :key="link.route"
    :href="route(link.route)"
    :class="[
        'block rounded px-4 py-2 text-sm',
        route().current(link.active)
            ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-200'
            : 'text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700'
    ]"
>
    {{ link.label }}
</Link>



    </div>
</div>

  
                        </div>

                    </div>

                    <!-- Right -->
                    <div class="hidden sm:flex sm:items-center">

                        <template v-if="user">

                            <Dropdown align="right" width="48">

                                <template #trigger>

                                    <span class="inline-flex rounded-md">

                                        <button
                                            type="button"
                                            class="inline-flex items-center rounded-md border border-transparent bg-white dark:bg-gray-800 px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100"
                                        >

<img
    v-if="user.avatar"
    :src="user.avatar"
    :alt="user.name"
    class="mr-2 h-8 w-8 rounded-full object-cover"
/>


                                            {{ user.name }}

                                            <svg
                                                class="ms-2 h-4 w-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>

                                        </button>

                                    </span>

                                </template>

                                <template #content>

                                    <DropdownLink :href="route('profile.edit')">
                                        Profile
                                    </DropdownLink>

                                    <DropdownLink
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                    >
                                        Log Out
                                    </DropdownLink>

                                </template>

                            </Dropdown>

                        </template>

                        <template v-else>

                            <div class="flex items-center gap-4">

                                <Link
                                    :href="route('login')"
                                    class="text-sm text-gray-600 hover:text-gray-900"
                                >
                                    Login
                                </Link>

                                <Link
                                    :href="route('register')"
                                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
                                >
                                    Register
                                </Link>

                            </div>

                        </template>

                    </div>

                    <!-- Mobile button -->
<div class="absolute inset-0 flex items-center justify-center pointer-events-none sm:hidden">
    <span class="text-base font-semibold">
        {{ title }}
    </span>
</div>
                    <div class="-me-2 flex items-center sm:hidden">

                        <button
                            @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="inline-flex items-center justify-center rounded-md p-2 text-gray-500"
                        >

                            ☰

                        </button>

                    </div>

                </div>
            </div>

            <!-- Mobile -->

            <div
                v-show="showingNavigationDropdown"
                class="sm:hidden border-t border-gray-200"
            >


                
<ResponsiveNavLink
    v-for="link in mainLinks"
    :key="link.route"
    :href="route(link.route)"
    :active="route().current(link.active)"
>
    {{ link.label }}
</ResponsiveNavLink>

<button
    @click="mobileApprovalsOpen = !mobileApprovalsOpen"
    class="flex w-full items-center justify-between px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200"
>
    <span>Approvals</span>
    <span>{{ mobileApprovalsOpen ? '▲' : '▼' }}</span>
</button>
<div v-if="mobileApprovalsOpen" class="ml-4">


<ResponsiveNavLink
    v-for="link in approvalLinks"
    :key="link.route"
    :href="route(link.route)"
    :active="route().current(link.active)"
>
    {{ link.label }}
</ResponsiveNavLink>


</div>




                <template v-if="user">

                    <div class="border-t border-gray-200 px-4 py-4">




<div class="flex items-center gap-3">
    <img
        v-if="user.avatar"
        :src="user.avatar"
        :alt="user.name"
        class="h-10 w-10 rounded-full object-cover"
    />

    <div>
        <div class="font-medium">
            {{ user.name }}
        </div>

        <div class="text-sm text-gray-500">
            {{ user.email }}
        </div>
    </div>
</div>




                    </div>

                    <ResponsiveNavLink
                        :href="route('profile.edit')"
                    >
                        Profile
                    </ResponsiveNavLink>

                    <ResponsiveNavLink
                        :href="route('logout')"
                        method="post"
                        as="button"
                    >
                        Log Out
                    </ResponsiveNavLink>

                </template>

                <template v-else>

                    <ResponsiveNavLink :href="route('login')">
                        Login
                    </ResponsiveNavLink>

                    <ResponsiveNavLink :href="route('register')">
                        Register
                    </ResponsiveNavLink>

                </template>

            </div>

        </nav>



<header
    v-if="$slots.header"
    class="bg-white shadow dark:bg-gray-800"
>


            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <main>
            <slot />
        </main>

    </div>
</template>
