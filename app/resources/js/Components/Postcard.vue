<script setup>
import {ref} from 'vue';

const props = defineProps({
    title: {
        type: String,
    },
    teaser: {
        type: String,
    },
    created: {
        type: String,
    },
    rating: {
        type: Number,
    },
});

function upFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
</script>

<template>
    <div class="flex flex-col justify-center bg-white group my-5 overflow-hidden shadow-lg sm:rounded-lg hover:scale-[1.01] transition-all duration-200 cursor-pointer motion-reduce:transition-none motion-reduce:hover:transform-none">

        <div class="flex-none bg-gray-200 text-3xl p-6 text-gray-700 group-hover:text-gray-400 transition-all duration-500 cursor-pointer motion-reduce:transition-none motion-reduce:hover:transform-none">
            {{ upFirstLetter(title) }}
        </div>

        <div class="py-5 px-6 text-gray-700">
            {{ upFirstLetter(teaser) }}
        </div>

        <div class="flex justify-between items-center">
            <div class="m-5 text-gray-500">
                Rating: {{ rating }}
            </div>
            <div class="m-5 text-gray-400 text-xs">
                Created: {{ created }}
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
