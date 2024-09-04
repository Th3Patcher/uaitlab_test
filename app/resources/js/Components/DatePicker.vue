<script setup>
import { ref } from 'vue';

const selectedDate = ref(null);

const emit = defineEmits(['update:modelValue']);

function updateDate(event) {
    selectedDate.value = event.target.value;
    emit('update:modelValue', selectedDate.value);
}
</script>

<template>
    <div class="relative max-w-sm">
        <div class="absolute inset-y-0 start-0 flex items-center pl-3 pointer-events-none">
            <svg
                class="w-4 h-4 text-gray-500"
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                viewBox="0 0 20 20"
                aria-hidden="true"
            >
                <path
                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"
                />
            </svg>
        </div>
        <input
            type="date"
            :value="selectedDate"
            @input="updateDate"
            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-indigo-600 focus:border-indigo-600 block w-full pl-10 p-2.5"
            placeholder="Select date"
        />
    </div>
</template>

<style scoped>

</style>
