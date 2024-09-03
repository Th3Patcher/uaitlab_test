<script setup>
import AuthenticatedLayout from "@/Layouts/AdminLayout.vue";
import Tabs from "@/Components/Tabs.vue"
import {Head, Link} from "@inertiajs/vue3";
import {ref, computed, watch} from 'vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import api from '@/api.js';

const props = defineProps({
    defectCodes: Array,
    symptomCodes: Array,
});

const activeTab = ref(0);
const tabs = ref(['Defect', 'Symptom']);
const tableData = ref([]);
const search = ref('');

const fetchData = async () => {
    try {
        const response = await api.get('/directories/tab-data', {
            params: {
                type: tabs.value[activeTab.value],
                search: search.value
            },
        });
        tableData.value = response.data;
    } catch (error) {
        console.error('Failed to fetch data:', error);
    }
};

const filteredTableData = computed(() => {
    const query = search.value.toLowerCase();
    return tableData.value.filter(item =>
        item.name.toLowerCase().includes(query) && item.children && item.children.length > 0
    );
});

watch([activeTab, search], fetchData, { immediate: true });

fetchData();
</script>

<template>
    <Head title="Directories"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Directories</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="relative overflow-x-auto rounded-xl">
                    <!-- Directory Tabs -->
                    <ul class="flex flex-wrap items-end text-sm font-medium text-center text-gray-400 border-b border-gray-200">
                        <li class="me-2 shadow-xl " v-for="(tab, index) in tabs" :key="tab">
                            <Tabs :index="index" :activeTab="activeTab" @update:activeTab="activeTab = $event">
                                {{ tab }}
                            </Tabs>
                        </li>

                    </ul>

                    <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4 bg-gray-300">
                        <div class="w-full md:w-1/2">
                            <form class="flex items-center">
                                <label for="simple-search" class="sr-only">Search</label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" id="simple-search" v-model="search" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Search" required="">
                                </div>
                            </form>
                        </div>
                        <Link :href="route('admin.directory.create')">
                            <PrimaryButton
                                class="flex items-center justify-center">
                                Add new code
                            </PrimaryButton>
                        </Link>
                    </div>
                    <!-- Table -->
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 shadow-lg">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Id
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-for="item in filteredTableData" :key="item.id">
                            <tr class="group bg-gray-50 border-b text-gray-800 hover:bg-gray-300 transition-all duration-200">
                                <th scope="row" class="px-6 py-4 font-bold whitespace-nowrap">
                                </th>
                                <td class="px-6 py-4 font-bold text-lg">
                                    {{ item.name }}
                                </td>
                                <td class="px-6 py-4 font-bold text-lg">
                                    <Link :href="route('admin.directory.show', {type: tabs[activeTab], id: item.id})" class="transition-all duration-200 opacity-0 group-hover:opacity-100 hover:bg-gray-400 rounded p-1">
                                        Edit
                                    </Link>
                                </td>
                            </tr>
                            <!-- Child Rows -->
                            <tr v-for="child in item.children" :key="child.id" class="bg-gray-100 border-b text-gray-800 hover:bg-gray-200 transition-all duration-200">
                                <th scope="row" class="px-6 py-4 pl-12 font-normal whitespace-nowrap">
                                    {{ child.id }}
                                </th>
                                <td class="px-6 py-4 pl-12">
                                    {{ child.name }}
                                </td>
                                <td class="px-6 py-4">
                                    <Link :href="route('admin.directory.show', {type: tabs[activeTab], id: child.id})" class="transition-all duration-200 hover:bg-gray-400 rounded p-1">
                                        Edit
                                    </Link>
                                </td>
                            </tr>
                        </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


<style scoped>

</style>
