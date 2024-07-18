<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({ posts: Object })

function upFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
</script>
<template>
    <Head title="Posts" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Posts</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-3 gap-4">
                <div v-for="post in props.posts" class="bg-white group my-5 overflow-hidden shadow-lg sm:rounded-lg hover:scale-110 transition-all duration-500 cursor-pointer motion-reduce:transition-none motion-reduce:hover:transform-none">
                    <div class="relative p-5">
                        <div class="absolute top-1/2 l;eft-4 text-3xl text-gray-700 group-hover:text-gray-400 transition-all duration-500 cursor-pointer motion-reduce:transition-none motion-reduce:hover:transform-none">
                            {{ upFirstLetter(post.title) }}
                        </div>
                    </div>
                    <div class="pt-12 pb-4 px-6 text-gray-700">
                        {{ upFirstLetter(post.body) }}
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
