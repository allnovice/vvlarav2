<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

const showingNavigationDropdown = ref(false);

const page = usePage();

const user = computed(() => page.props.auth?.user ?? null);
</script>

<template>
    <div class="min-h-screen bg-gray-100">

        <nav class="border-b border-gray-100 bg-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">

                    <!-- Left -->
                    <div class="flex">

                        <div class="flex shrink-0 items-center">
                            <Link href="/">
                                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                            </Link>
                        </div>

                        <div class="hidden sm:ms-10 sm:flex sm:space-x-8">

                            <NavLink
                                href="/"
                                :active="route().current('/')"
                            >
                                Dashboard
                            </NavLink>

                            <NavLink
                                :href="route('assets')"
                                :active="route().current('assets')"
                            >
                                Assets
                            </NavLink>

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
                                            class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700"
                                        >
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

                <ResponsiveNavLink href="/">
                    Dashboard
                </ResponsiveNavLink>

                <ResponsiveNavLink :href="route('assets')">
                    Assets
                </ResponsiveNavLink>

                <template v-if="user">

                    <div class="border-t border-gray-200 px-4 py-4">

                        <div class="font-medium">
                            {{ user.name }}
                        </div>

                        <div class="text-sm text-gray-500">
                            {{ user.email }}
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
            class="bg-white shadow"
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
