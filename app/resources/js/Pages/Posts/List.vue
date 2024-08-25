<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Postcard from "@/Components/Postcard.vue";

const props = defineProps({ posts: Object })
</script>
<template>
    <Head title="Posts" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Posts</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 gap-4">
                <Postcard v-for="post in props.posts" :title="post.title" :teaser="post.body" :created="post.created_at" :rating="post.rating">
                </Postcard>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
