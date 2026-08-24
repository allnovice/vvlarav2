<script setup>
import { computed } from 'vue'

const props = defineProps({
    releases: Array,
})

function formatDate(date) {
    if (!date) return ''

    return new Date(date).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
    })
}

function cleanBody(body) {
    if (!body) return []

    return body
        .split('\n')
        .map(line => line.trim())
        .filter(line =>
            line &&
            !line.startsWith('## ') &&
            !line.startsWith('### ')
        )
        .map(line => line.replace(/^\*\s+/, ''))
        .map(line => line.replace(/\[([^\]]+)\]\([^)]+\)/g, '$1'))
        .map(line => line.replace(/\*\*(.*?)\*\*/g, '$1'))
}

const formattedReleases = computed(() =>
    (props.releases ?? []).map(release => ({
        ...release,
        changes: cleanBody(release.body),
    }))
)
</script>

<template>
    <div class="mt-6">
        <h2 class="text-lg font-semibold">
            What's New
        </h2>

        <div class="mt-3 space-y-4">

            <div
                v-for="release in formattedReleases"
                :key="release.id"
                class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800"
            >
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold">
                        {{ release.name || release.tag_name }}
                    </h3>

                    <span class="text-sm text-gray-500">
                        {{ formatDate(release.published_at) }}
                    </span>
                </div>

                <ul
                    v-if="release.changes.length"
                    class="mt-3 list-disc space-y-1 pl-5 text-sm text-gray-700 dark:text-gray-300"
                >
                    <li
                        v-for="(change, index) in release.changes"
                        :key="index"
                    >
                        {{ change }}
                    </li>
                </ul>

                <a
                    v-if="release.html_url"
                    :href="release.html_url"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="mt-3 inline-block text-sm text-indigo-600 hover:underline dark:text-indigo-400"
                >
                    View release →
                </a>
            </div>

        </div>
    </div>
</template>