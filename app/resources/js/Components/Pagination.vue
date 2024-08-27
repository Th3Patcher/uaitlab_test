<script>
import { Link } from '@inertiajs/vue3';

export default {
    name: "Pagination",
    components: {
        Link
    },
    props: {
        pagination: Object,
    }
}
</script>

<template>
    <nav class="relative flex justify-center">
        <template v-for="link in pagination.links" :key="link.label">
            <Link
                preserve-scroll
                :href="link.url ?? ''"
                v-html="link.label"
                class="flex items-center justify-center px-3 py-2 my-2 text-sm rounded-lg text-gray-600 "
                :class="{'bg-indigo-200': link.active, 'text-indigo-200 cursor-default': !link.url}"
            />
        </template>
    </nav>
</template>

<style scoped>

</style>
