<script setup>
const props = defineProps({
    header: {
        type: String,
        default: '',
    },
});
</script>

<template>
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg inline-block">
        <header>
            <!--   GENERAL PART    -->
            <h2 class="text-xl font-medium mb-5 text-gray-900">{{ header }}</h2>

            <div class="flex flex-wrap justify-around gap-y-5">
                <slot/>
            </div>
        </header>
    </div>
</template>

<style scoped>

</style>
