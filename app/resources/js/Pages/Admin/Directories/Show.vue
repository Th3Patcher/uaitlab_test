<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import {ref} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    code: Object,
    type: String,
})

const form = useForm({
    type: props.type,
    name: props.code.name,
    id: props.code.id,
});

</script>

<template>
    <Head title="Directories"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Directories / Edit {{ props.type }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Edit {{ props.type }} code</h2>

                            <p class="mt-1 text-sm text-gray-600">
                                Change name or parent folder for this code
                            </p>
                        </header>

                        <form @submit.prevent="form.patch(route('directory.update'))" class="mt-6 space-y-6">
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
                                    <span>
                                        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                                        <p v-if="form.hasErrors" class="text-sm text-red-300">Error</p>
                                    </span>
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
