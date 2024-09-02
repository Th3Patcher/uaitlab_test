<script setup>
const props = defineProps({
    index: Number,
    activeTab: Number
});

const emits = defineEmits(['update:activeTab']);

const selectTab = () => {
    emits('update:activeTab', props.index);
};
</script>

<template>
    <a href="#"
       @click.prevent="selectTab"
       :class="{'text-gray-100 bg-gray-400 text-xl': activeTab === index, 'hover:bg-gray-200': activeTab !== index}"
       class="inline-block p-4 rounded-t-lg text-gray-600 bg-gray-50 transition-all duration-200">
        <slot/>
    </a>
</template>

<style scoped>

</style>
