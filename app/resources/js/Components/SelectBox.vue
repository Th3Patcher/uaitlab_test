<script setup>
import {computed, ref} from 'vue';

const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: null
    },
    options: {
        type: Array,
        required: true
    },
    placeholder: {
        type: String,
        default: 'Select an option',
        required: false,
    }
});

const emit = defineEmits(['update:modelValue']);

const isOpen = ref(false);
const selectedValue = ref(props.modelValue);

const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
};

const selectOption = (option) => {
    selectedValue.value = option.value;
    emit('update:modelValue', option.value);
    isOpen.value = false;
};

const selectedLabel = computed(() => {
    const selectedOption = props.options.find(option => option.value === selectedValue.value);
    return selectedOption ? selectedOption.label : props.placeholder;
});
</script>

<template>
    <div class="relative inline-block">
        <div @click="toggleDropdown" class="border border-gray-300 bg-white rounded-md shadow-sm px-4 py-2 cursor-pointer flex justify-between items-center">
            <span>{{ selectedLabel }}</span>
            <svg v-if="!isOpen" class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
            <svg v-else class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 15l-7-7-7 7"></path>
            </svg>
        </div>
        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 transform scale-95"
            enter-to-class="opacity-100 transform scale-100"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 transform scale-100"
            leave-to-class="opacity-0 transform scale-95">
            <div v-if="isOpen" class="absolute mt-1 w-full rounded-xl shadow-lg bg-white z-50">
                <ul class="max-h-60 rounded-xl py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                    <li
                        v-for="option in options"
                        :key="option.value"
                        @click="selectOption(option)"
                        class="cursor-pointer select-none relative py-2 pl-10  hover:bg-indigo-600 hover:text-white transition-colors duration-200"
                        :class="{'bg-indigo-600 text-white': option.value === selectedValue}">
                        <span class="block truncate">{{ option.label }}</span>
                        <span v-if="option.value === selectedValue" class="absolute inset-y-0 left-0 flex items-center pl-3">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
          </span>
                    </li>
                </ul>
            </div>
        </Transition>
    </div>
</template>

<style scoped>

</style>
