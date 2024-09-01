<script setup>
import {ref, computed} from 'vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";

const props =   defineProps({
    defectCodes: Array,
    symptomCodes: Array,
});

// State for active directory and tab
const activeDirectory = ref('Defect');
const activeTab = ref(0);

// Compute the tabs based on the selected directory
const tabs = computed(() => {
    const codes = activeDirectory.value === 'Defect' ? props.defectCodes : props.symptomCodes;
    return codes.map(code => code.type);
});

const filteredTableData = computed(() => {
    const codes = activeDirectory.value === 'Defect' ? props.defectCodes : props.symptomCodes;
    return codes.filter(code => code.type === tabs.value[activeTab.value]);
});

</script>

<template>
    <Head title="Directories"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Directories</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="relative overflow-x-auto rounded-xl shadow-lg">
                    <!-- Directory Tabs -->
                    <ul class="flex flex-wrap text-sm font-medium text-center text-gray-400 border-b border-gray-200">
                        <li class="me-2">
                            <a href="#" @click="activeDirectory = 'Defect'; activeTab = 0"
                               :class="{'text-blue-600 bg-gray-100': activeDirectory === 'Defect', 'hover:text-gray-600 hover:bg-gray-50': activeDirectory !== 'Defect'}"
                               class="inline-block p-4 rounded-t-lg">
                                Defect
                            </a>
                        </li>
                        <li class="me-2">
                            <a href="#" @click="activeDirectory = 'Symptom'; activeTab = 0"
                               :class="{'text-blue-600 bg-gray-100': activeDirectory === 'Symptom', 'hover:text-gray-600 hover:bg-gray-50': activeDirectory !== 'Symptom'}"
                               class="inline-block p-4 rounded-t-lg">
                                Symptom
                            </a>
                        </li>
                    </ul>

                    <!-- Table -->
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 mt-4">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Id
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in filteredTableData" :key="item.id" class="bg-white border-b">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ item.id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ item.name }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


<style scoped>

</style>
