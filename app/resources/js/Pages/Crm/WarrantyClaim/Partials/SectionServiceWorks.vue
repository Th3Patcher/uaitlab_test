<script setup>
import SelectBox from "@/Components/SelectBox.vue";
import Search from "@/Pages/Crm/WarrantyClaim/Partials/Search.vue";
import {ref, watch} from "vue";
import api from "@/api.js";
import InputError from "@/Components/InputError.vue";
import ServiceTable from "@/Pages/Crm/WarrantyClaim/Partials/ServiceTable.vue";

const search = ref("");
const selectedGroup = ref(null);
const errors = ref();
const table = ref([]);
const selectedItems = ref(new Map());

const emit = defineEmits(['update:serviceworks', 'update:group']);
const handleUpdateSelected = (newSelectedItems) => {
    selectedItems.value = new Map(newSelectedItems);
    emit('update:serviceworks', new Map(newSelectedItems));
};

//Generate group of products
const groups = Array.from({length: 10}, (_, i) => ({
    value: i + 1,
    label: `Group of items ${i + 1}`
}));

watch([selectedGroup, search], async () => {
    if (selectedGroup.value) {
        try {
            const response = await api.get(`warranty_claim_service_works/list`, {
                params: {
                    line_number: selectedGroup.value,
                    product: search.value
                }
            });
            errors.value = '';
            if (response.data.message) {
                errors.value = response.data.message;
                table.value = null
            } else {
                emit('update:group', selectedGroup.value);
                table.value = response.data.map(item => ({
                    ...item,
                    hours: item.hours || 0,
                    sum: (item.price * (item.hours || 0)).toFixed(2),
                    selected: selectedItems.value.has(item.id) || false
                }));
            }
        } catch (error) {
            table.value = [];
        }
    }
});
</script>

<template>
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg inline-block w-full">
        <header>
            <h2 class="text-xl font-medium mb-5 text-gray-900">Service works</h2>
                            <InputError class="mt-2" :message="errors"/>
            <div class="relative">
                <div
                    class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
                    <SelectBox
                        :placeholder="'Choose a group of items'"
                        :options="groups"
                        v-model="selectedGroup"
                    />
                    <Search class="inline-block w-1/3"
                            :placeholder="'Insert name of service works'"
                            v-model="search"
                    />
                </div>
                <ServiceTable
                :table="table"
                :selected="selectedItems"
                @update:selected="handleUpdateSelected"/>
            </div>

        </header>
    </div>
</template>

<style scoped>

</style>
