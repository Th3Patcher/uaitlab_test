<script setup>
import {onMounted, ref} from "vue";

defineProps()
const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <textarea
        id="message"
        rows="4"
        v-model="model"
        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-indigo-600 focus:border-indigo-600">
    </textarea>
</template>

<style scoped>

</style>
