<script setup>

import TextInput from "@/Components/TextInput.vue";
import Search from "@/Pages/Crm/WarrantyClaim/Partials/Search.vue";
import InputError from "@/Components/InputError.vue";
import {computed, ref, watch} from "vue";
import api from "@/api.js";

const search = ref("");
const errors = ref();
const result = ref([]);
const selectedItems = ref([]);

const emit = defineEmits(['update:spareparts']);

const props = defineProps({
    searchTable: {
        type: Array,
        default: [],
        required: false,
    },
});
const addItemToSelected = (item) => {
    if (!selectedItems.value.find(selectedItem => selectedItem.articul === item.articul)) {
        selectedItems.value.push(item);
    }

    emit('update:spareparts', selectedItems.value);
};

const deleteItemToSelected = (item) => {
    selectedItems.value = selectedItems.value.filter(selectedItem => selectedItem.articul !== item.articul);

    emit('update:spareparts', selectedItems.value);
};

const totalSum = computed(() => {
    return selectedItems.value.reduce((total, item) => {
        const itemTotal = item.price * item.qty * (1 - item.discount / 100);
        return total + itemTotal;
    }, 0);
});

watch([search], async () => {
    if (search.value) {
        try {
            const response = await api.get(`warranty_claim_spareparts/list`, {
                params: {
                    articul: search.value
                }
            });
            errors.value = '';
            if (response.data.message) {
                errors.value = response.data.message;
                result.value = []
            } else {
                result.value = response.data
                console.log(result.value);
            }
        } catch (error) {
            result.value = [];
        }
    }
});

</script>

<template>
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg inline-block w-full">
        <header>
            <h2 class="text-xl font-medium mb-5 text-gray-900">Spareparts</h2>
            <InputError class="mt-2" :message="errors"/>
            <div class="relative">
                <div
                    class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
                    <Search class="inline-block w-1/3"
                            :placeholder="'Enter articule'"
                            v-model="search"
                    />
                </div>
                <div class="shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="p-4">
                                Articul
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Price₴
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Quantity
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Discount%
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Total
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody v-if="result && result.length">
                        <tr v-for="part in result" :key="part.articul" class="bg-white border-b">
                            <th scope="row"
                                class="px-6 py-4 ">
                                {{ part.articul }}
                            </th>
                            <td class="px-6 py-4 text-gray-900 whitespace-nowrap w-full">
                                {{ part.product }}
                            </td>
                            <td class="px-6 py-4">
                                {{ part.price }}
                            </td>
                            <td class="px-6 py-4">
                                {{ part.qty }}
                            </td>
                            <td class="px-6 py-4">
                                {{ part.discount }}%
                            </td>
                            <td class="px-6 py-4">
                                {{  part.price * part.qty * (1 - part.discount / 100)  }}
                            </td>
                            <td class="px-6 py-4">
                                <svg @click="addItemToSelected(part)"
                                     class="scale-50 cursor-pointer hover:scale-[0.6] transition duration-200"
                                     viewBox="0 0 32 32">
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                                           sketch:type="MSPage">
                                            <g id="Icon-Set-Filled" sketch:type="MSLayerGroup"
                                               transform="translate(-466.000000, -1089.000000)" fill="#000000">
                                                <path
                                                    d="M488,1106 L483,1106 L483,1111 C483,1111.55 482.553,1112 482,1112 C481.447,1112 481,1111.55 481,1111 L481,1106 L476,1106 C475.447,1106 475,1105.55 475,1105 C475,1104.45 475.447,1104 476,1104 L481,1104 L481,1099 C481,1098.45 481.447,1098 482,1098 C482.553,1098 483,1098.45 483,1099 L483,1104 L488,1104 C488.553,1104 489,1104.45 489,1105 C489,1105.55 488.553,1106 488,1106 L488,1106 Z M482,1089 C473.163,1089 466,1096.16 466,1105 C466,1113.84 473.163,1121 482,1121 C490.837,1121 498,1113.84 498,1105 C498,1096.16 490.837,1089 482,1089 L482,1089 Z"
                                                    id="plus-circle" sketch:type="MSShapeGroup"></path>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div v-if="selectedItems && selectedItems.length" class="mt-5 overflow-x-auto">
                        <h2 class="text-xl font-medium mb-5 text-gray-900 pl-5">Used parts</h2>
                        <div class="shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 ">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="p-4">
                                        Articul
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Price₴
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Quantity
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Discount%
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Total
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(part, key) in selectedItems" :key="key" class="bg-white border-b">
                                    <th scope="row"
                                        class="px-6 py-4 ">
                                        {{ part.articul }}
                                    </th>
                                    <td class="px-6 py-4 text-gray-900 whitespace-nowrap w-full">
                                        {{ part.product }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ part.price }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <TextInput
                                            :id="`hours_`+ key"
                                            type="number"
                                            min="0"
                                            class="mt-1 block"
                                            required
                                            v-model="part.qty"
                                        />
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ part.discount }}%
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ part.price * part.qty * (1 - part.discount / 100) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <svg @click="deleteItemToSelected(part)"
                                             class="scale-50 cursor-pointer hover:scale-[0.6] transition duration-200"
                                             viewBox="0 0 32 32" fill="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                               stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier"><title>minus-circle</title>
                                                <desc>Created with Sketch Beta.</desc>
                                                <defs></defs>
                                                <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                                   fill-rule="evenodd" sketch:type="MSPage">
                                                    <g id="Icon-Set-Filled" sketch:type="MSLayerGroup"
                                                       transform="translate(-518.000000, -1089.000000)" fill="#000000">
                                                        <path
                                                            d="M540,1106 L528,1106 C527.447,1106 527,1105.55 527,1105 C527,1104.45 527.447,1104 528,1104 L540,1104 C540.553,1104 541,1104.45 541,1105 C541,1105.55 540.553,1106 540,1106 L540,1106 Z M534,1089 C525.163,1089 518,1096.16 518,1105 C518,1113.84 525.163,1121 534,1121 C542.837,1121 550,1113.84 550,1105 C550,1096.16 542.837,1089 534,1089 L534,1089 Z"
                                                            id="minus-circle" sketch:type="MSShapeGroup"></path>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
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
                    </div>
                </div>
            </div>
        </header>
    </div>
</template>

<style scoped>

</style>
