<script setup>

import UserLayout from "@/Layouts/UserLayout.vue";
import {Head, useForm, usePage} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import {ref, watch} from "vue";
import SelectBox from "@/Components/SelectBox.vue";
import DatePicker from "@/Components/DatePicker.vue";
import Section from "@/Pages/Crm/WarrantyClaim/Partials/Section.vue";
import TextArea from "@/Components/TextArea.vue";

const user = usePage().props.auth.user;
const selectedOption = ref(null);

const form = useForm({
    name: user.name,
    email: user.email,
    date: '',
});

const options = ref([
    {value: 'Test11', label: 'Test11'},
    {value: 'Test1', label: 'Test1'},
    {value: 'test3', label: 'test3'}
]);


watch(form.date, (newDate) => {
    console.log('Selected Date:', newDate);
    form.date = newDate;
});
</script>

<template>
    <Head title="Create Claim"/>
    <UserLayout>
        <template #header>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight inline-block">Create Warranty Claim</h2>
        </template>

        <div class="py-12">
            <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
                <form>
                    <Section
                        class="w-full"
                        :header="'General information'">
                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="service_contract" value="No. Document"/>

                            <TextInput
                                id="service_contract"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="service_contract"
                            />

                            <InputError class="mt-2" :message="form.errors.name"/>
                        </div>

                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="document_date" value="Document Date"/>

                            <DatePicker
                                id="document_date"
                                class="mt-1 block w-full"
                                v-model="form.date"
                                required
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.name"/>
                        </div>

                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="responsible" value="Responsible"/>

                            <TextInput
                                id="responsible"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="responsible"
                            />

                            <InputError class="mt-2" :message="form.errors.name"/>
                        </div>

                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="service_center" value="Service center"/>

                            <SelectBox
                                id="service_center"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                :options="options"/>

                            <InputError class="mt-2" :message="form.errors.name"/>
                        </div>
                    </Section>

                    <div class="flex flex-row mt-4 gap-5">
                        <Section
                            class="basis-1/2"
                            :header="'Data of the buyer'"
                        >
                            <div class="flex-initial basis-[48%]">
                                <InputLabel for="client_name" value="Buyer's full name"/>

                                <TextInput
                                    id="client_name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                    autocomplete="client_name"
                                />

                                <InputError class="mt-2" :message="form.errors.name"/>
                            </div>

                            <div class="flex-initial basis-[48%]">
                                <InputLabel for="client_phone" value="Phone number"/>

                                <TextInput
                                    id="client_phone"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                    autocomplete="client_phone"
                                />

                                <InputError class="mt-2" :message="form.errors.name"/>
                            </div>
                        </Section>
                        <Section
                            class="basis-1/2"
                            :header="'Data of the applicant'">
                            <div class="flex-initial basis-[48%]">
                                <InputLabel for="sender_name" value="Applicant's full name"/>

                                <TextInput
                                    id="sender_name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                    autocomplete="sender_name"
                                />

                                <InputError class="mt-2" :message="form.errors.name"/>
                            </div>

                            <div class="flex-initial basis-[48%]">
                                <InputLabel for="sender_phone" value="Phone number"/>

                                <TextInput
                                    id="sender_phone"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                    autocomplete="sender_phone"
                                />

                                <InputError class="mt-2" :message="form.errors.name"/>
                            </div>
                        </Section>
                    </div>

                    <Section
                        class="w-full mt-4"
                        :header="'Product data'">
                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="product_article" value="Article"/>

                            <TextInput
                                id="product_article"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="product_article"
                            />

                            <InputError class="mt-2" :message="form.errors.name"/>
                        </div>

                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="product_name" value="Name of product"/>

                            <TextInput
                                id="product_name"
                                class="mt-1 block w-full"
                                v-model="form.date"
                                required
                                autofocus
                                autocomplete="product_name"
                            />

                            <InputError class="mt-2" :message="form.errors.name"/>
                        </div>

                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="factory_number" value="Factory number"/>

                            <TextInput
                                id="factory_number"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="factory_number"
                            />

                            <InputError class="mt-2" :message="form.errors.name"/>
                        </div>

                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="service_contract" value="Barcode of the warranty card"/>

                            <TextInput
                                id="service_contract"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="service_contract"
                            />

                            <InputError class="mt-2" :message="form.errors.name"/>
                        </div>

                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="point_of_sale" value="Point of sale"/>

                            <TextInput
                                id="point_of_sale"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="point_of_sale"
                            />

                            <InputError class="mt-2" :message="form.errors.name"/>
                        </div>

                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="date_of_sale" value="Date of sale"/>

                            <DatePicker
                                id="date_of_sale"
                                class="mt-1 block w-full"
                                v-model="form.date"
                                required
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.name"/>
                        </div>

                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="date_of_claim" value="Date of contacting the service centre"/>

                            <DatePicker
                                id="date_of_claim"
                                class="mt-1 block w-full"
                                v-model="form.date"
                                required
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.name"/>
                        </div>

                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="service_partner" value="Service centre receipt number"/>

                            <TextInput
                                id="service_partner"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="service_partner"
                            />

                            <InputError class="mt-2" :message="form.errors.name"/>
                        </div>
                    </Section>

                    <Section
                        class="w-full mt-4"
                        :header="'Defect description'">
                        <div class="flex-initial basis-[48%]">
                            <InputLabel for="defect_description" value="Exact description of the defect"/>

                            <TextArea
                                id="defect_description"
                                class="mt-1"
                                v-model="form.name"
                                placeholder="Exact description of the defect"
                                required
                                autofocus
                                autocomplete="defect_description"
                            />

                            <InputError class="mt-2" :message="form.errors.name"/>
                        </div>

                        <div class="flex-initial basis-[48%]">
                            <InputLabel for="defect_reason" value="Reason for defect"/>

                            <TextArea
                                id="service_contract"
                                class="mt-1"
                                v-model="form.name"
                                placeholder="Reason for defect"
                                required
                                autofocus
                                autocomplete="defect_reason"
                            />

                            <InputError class="mt-2" :message="form.errors.name"/>
                        </div>
                    </Section>
                    <Section
                        class="w-full mt-4"
                        :header="'Other'">
                        <div class="flex-initial basis-full">
                            <InputLabel for="comment" value="Comment"/>

                            <TextArea
                                id="comment"
                                class="mt-1"
                                v-model="form.name"
                                placeholder="Comment claim"
                                required
                                autofocus
                                autocomplete="comment"
                            />

                            <InputError class="mt-2" :message="form.errors.name"/>
                        </div>
                    </Section>

                </form>
            </div>
        </div>
    </UserLayout>
</template>

<style scoped>

</style>
