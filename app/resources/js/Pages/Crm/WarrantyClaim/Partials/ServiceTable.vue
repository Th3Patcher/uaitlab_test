<script setup>

import TextInput from "@/Components/TextInput.vue";
import {computed, ref, watch} from "vue";

const emit = defineEmits(['update:selected']);

const props = defineProps({
    table: {
        type: Array,
        default: [],
        required: false
    },
    selected: {
        type: Map,
        default: new Map(),
        required: false
    }
});

const selectedItems = ref(new Map(props.selected.value));

const updateSum = (code_1c) => {
    const item = props.table.find(item => item.code_1c === code_1c);
    if (item) {
        if (selectedItems.value.has(code_1c)) {
            selectedItems.value.set(code_1c, item.hours);
            emit('update:selected', selectedItems.value);
        }
        item.sum = (item.price * item.hours).toFixed(2);
    }
};

const toggleSelect = (code_1c) => {
    const item = props.table.find(item => item.code_1c === code_1c);
    if (selectedItems.value.has(code_1c)) {
        selectedItems.value.delete(code_1c);
    } else {
        selectedItems.value.set(code_1c, parseFloat(item.hours) || 0 );
    }

    emit('update:selected', selectedItems.value);
};

const totalSum = computed(() => {
    return Array.from(selectedItems.value.entries()).reduce((total, [code_1c, { hours }]) => {
        const item = props.table.find(item => item.code_1c === code_1c);
        const itemPrice = parseFloat(item?.price) || 0;
        return total + (itemPrice * selectedItems.value.get(code_1c));
    }, 0).toFixed(2);
});

watch(props.selected, (newSelected) => {
    selectedItems.value = new Map(newSelected);
}, { immediate: true });
</script>

<template>
    <div class="shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="p-4">
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Price₴
                </th>
                <th scope="col" class="px-6 py-3">
                    Hours
                </th>
                <th scope="col" class="px-6 py-3">
                    Sum
                </th>
            </tr>
            </thead>
            <tbody v-if="table && table.length">
            <tr v-for="service in table" :key="service.code_1c" class="bg-white border-b">
                <td class="w-4 p-4">
                    <div class="flex items-center">
                        <input :id="`checkbox-table-search-` + service.code_1c" type="checkbox"
                               :checked="service.selected"
                               @change="toggleSelect(service.code_1c)"
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                        <label :for="`checkbox-table-search-` + service.code_1c" class="sr-only">checkbox</label>
                    </div>
                </td>
                <th scope="row"
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap w-full">
                    {{ service.product }}
                </th>
                <td class="px-6 py-4">
                    {{ service.price }}₴
                </td>
                <td class="px-6 py-4">
                    <TextInput  :id="`hours_`+ service.code_1c"
                                type="number"
                                step="any"
                                min="0"
                                class="mt-1 block"
                                required
                                v-model="service.hours"
                                @input="updateSum(service.code_1c)"/>
                </td>
                <td class="px-6 py-4">
                    {{ service.sum }}₴
                </td>
            </tr>
            </tbody>
            <tfoot class="relative overflow-hidden bg-white rounded-b-lg shadow-md">
            <tr class="bg-white border-b">
                <td class="px-6 py-4">
                </td>
                <td class="px-6 py-4">
                </td>
                <td class="px-6 py-4">
                </td>
                <td class="px-6 py-4">
                </td>
                <td class="px-6 py-4">
                    <h1 class="font-extrabold text-xl">Total: {{ totalSum }}₴</h1>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</template>

<style scoped>

</style>
