<script setup>
import {Head, Link, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import SelectBox from "@/Components/SelectBox.vue";
import {computed, ref, watch} from "vue";
import api from "@/api.js";
import PrimaryButton from "@/Components/PrimaryButton.vue";


const selectedType = ref(null);
const selectedFolder = ref(null);
const folders = ref([]);
const types = ref([
    {value: 'Defect', label: 'Defect'},
    {value: 'Symptom', label: 'Symptom'},
]);

const form = useForm({
    type: selectedType.value,
    folder: selectedFolder.value,
    name: '',
});

const fetchData = async () => {
    try {
        const response = await api.get('/directories/folders', {
            params: {
                type: selectedType.value,
            },
        });

        folders.value = response.data.map(folder => ({
            value: folder.code_1C,
            label: folder.name,
        }));
    } catch (error) {
        console.error('Failed to fetch data:', error);
    }
};

watch([selectedType, selectedFolder], () => {
    form.type = selectedType.value;
    form.folder = selectedFolder.value;
    if (selectedType.value) {
        fetchData();
    } else {
        folders.value = []; // Clear folders if no type is selected
        selectedFolder.value = null; // Clear selected folder
    }
});

const folder = computed(() => folders.value);
</script>

<template>
    <Head title="Directory - Create"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Directories</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Create code</h2>

                            <p class="mt-1 text-sm text-gray-600">
                                Choose a directory which you want to improve and name a new code
                            </p>
                        </header>

                        <form @submit.prevent="form.post(route('directory.store'))" class="mt-6 space-y-6">

                            <div>
                                <InputLabel value="Select type of directory"/>
                                <SelectBox v-model="selectedType" :options="types" class="w-full"/>
                                <InputError class="mt-2" :message="form.errors.type" />
                            </div>

                            <div v-if="selectedType">
                                <InputLabel value="Select type of folder" />
                                <SelectBox v-model="selectedFolder" :options="folder" class="w-full" />
                                <InputError class="mt-2" :message="form.errors.folder" />
                            </div>

                            <div>
                                <InputLabel for="name" value="Name of code"/>

                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                    autocomplete="name"
                                />
                                <InputError class="mt-2" :message="form.errors.name"/>
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                                </Transition>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
