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
import SectionServiceWorks from "@/Pages/Crm/WarrantyClaim/Partials/SectionServiceWorks.vue";
import SectionSpareParts from "@/Pages/Crm/WarrantyClaim/Partials/SectionSpareParts.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import api from "@/api.js";

const user = usePage().props.auth.user;
const selectedOption = ref(null);
const selectedGroup = ref(0);
const info = ref('');
const options = ref([]);


const form = useForm({
    //GENERAL
    document_number: '',
    document_date: '',
    autor: '',
    service_center: '',

    //DATA OF THE BUYER
    client_name: '',
    client_phone: '',

    //DATA OF THE APPLICANT
    sender_name: '',
    sender_phone: '',

    //PRODUCT DATA
    product_article: '',
    product_name: '',
    factory_number: '',
    warranty_card: '',
    point_of_sale: '',
    date_of_sale: '',
    date_of_claim: '',
    receipt_number: '',

    //DEFECT DESC
    exact_desc: '',
    reason_defect: '',

    //OTHER
    comment: '',

    //SERVICE WORKS
    serviceworks: [],
    group: selectedGroup.value,

    //SPAREPARTS
    spareparts: [],
})

const createClaim = () => {
    form.post(route('warranty-claims.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: (errors) => {
            console.log(errors);
        },
    });
};

const fetchServices = async () => {
    try {
        const response = await api.get('/warranty_claims/service-centers');
        options.value = response.data.map(item => ({value: item, label: item}));
    } catch (error) {
        options.value = [];
    }
};

//Spareparts
const handleUpdateSpareparts = (newSpareparts) => {
    form.spareparts = newSpareparts;
}
const handleUpdateGroup = (newGroup) => {
    form.group = newGroup
}

//Service works
const handleUpdateServiceWork = (newServiceWork) => {
    form.serviceworks = Array.from(newServiceWork.entries());
}

watch(form.date, (newDate) => {
    form.date = newDate;
});

fetchServices();
</script>

<template>
    <Head title="Create Claim"/>
    <UserLayout>
        <template #header>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight inline-block">Create Warranty Claim</h2>
        </template>

        <div class="py-12">
            <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="createClaim">
                    <Section
                        class="w-full"
                        :header="'General information'">
                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="document_number" value="No. Document"/>

                            <TextInput
                                id="document_number"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.document_number"
                                placeholder="No. Document"

                                autofocus
                                autocomplete="document_number"
                            />

                            <InputError class="mt-2" :message="form.errors.document_number"/>
                        </div>

                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="document_date" value="Document Date"/>

                            <DatePicker
                                id="document_date"
                                class="mt-1 block w-full"
                                v-model="form.document_date"
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.document_date"/>
                        </div>

                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="responsible" value="Responsible"/>

                            <TextInput
                                id="responsible"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.autor"
                                autofocus
                                autocomplete="responsible"
                            />

                            <InputError class="mt-2" :message="form.errors.autor"/>
                        </div>

                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="service_center" value="Service center"/>

                            <SelectBox
                                id="service_center"
                                class="mt-1 block w-full"
                                v-model="form.service_center"
                                :options="options"/>

                            <InputError class="mt-2" :message="form.errors.service_center"/>
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
                                    v-model="form.client_name"
                                    autofocus
                                    autocomplete="client_name"
                                />

                                <InputError class="mt-2" :message="form.errors.client_name"/>
                            </div>

                            <div class="flex-initial basis-[48%]">
                                <InputLabel for="client_phone" value="Phone number"/>

                                <TextInput
                                    id="client_phone"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.client_phone"
                                    autofocus
                                    autocomplete="client_phone"
                                />

                                <InputError class="mt-2" :message="form.errors.client_phone"/>
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
                                    v-model="form.sender_name"
                                    autofocus
                                    autocomplete="sender_name"
                                />

                                <InputError class="mt-2" :message="form.errors.sender_name"/>
                            </div>

                            <div class="flex-initial basis-[48%]">
                                <InputLabel for="sender_phone" value="Phone number"/>

                                <TextInput
                                    id="sender_phone"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.sender_phone"
                                    autofocus
                                    autocomplete="sender_phone"
                                />

                                <InputError class="mt-2" :message="form.errors.sender_phone"/>
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
                                v-model="form.product_article"
                                autofocus
                                autocomplete="product_article"
                            />

                            <InputError class="mt-2" :message="form.errors.product_article"/>
                        </div>

                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="product_name" value="Name of product"/>

                            <TextInput
                                id="product_name"
                                class="mt-1 block w-full"
                                v-model="form.product_name"
                                autofocus
                                autocomplete="product_name"
                            />

                            <InputError class="mt-2" :message="form.errors.product_name"/>
                        </div>

                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="factory_number" value="Factory number"/>

                            <TextInput
                                id="factory_number"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.factory_number"
                                autofocus
                                autocomplete="factory_number"
                            />

                            <InputError class="mt-2" :message="form.errors.factory_number"/>
                        </div>

                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="warranty_card" value="Barcode of the warranty card"/>

                            <TextInput
                                id="warranty_card"
                                class="mt-1 block w-full"
                                v-model="form.warranty_card"
                                autofocus
                                autocomplete="warranty_card"
                            />

                            <InputError class="mt-2" :message="form.errors.warranty_card"/>
                        </div>

                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="point_of_sale" value="Point of sale"/>

                            <SelectBox
                                id="point_of_sale"
                                class="mt-1 block w-full"
                                v-model="form.point_of_sale"
                                :options="options"/>

                            <InputError class="mt-2" :message="form.errors.point_of_sale"/>
                        </div>

                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="date_of_sale" value="Date of sale"/>

                            <DatePicker
                                id="date_of_sale"
                                class="mt-1 block w-full"
                                v-model="form.date_of_sale"
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.date_of_sale"/>
                        </div>

                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="date_of_claim" value="Date of contacting the service centre"/>

                            <DatePicker
                                id="date_of_claim"
                                class="mt-1 block w-full"
                                v-model="form.date_of_claim"
                                autofocus
                            />

                            <InputError class="mt-2" :message="form.errors.date_of_claim"/>
                        </div>

                        <div class="flex-initial basis-[24%]">
                            <InputLabel for="receipt_number" value="Service centre receipt number"/>

                            <TextInput
                                id="receipt_number"
                                class="mt-1 block w-full"
                                v-model="form.receipt_number"
                                autofocus
                                autocomplete="receipt_number"
                            />

                            <InputError class="mt-2" :message="form.errors.receipt_number"/>
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
                                v-model="form.exact_desc"
                                placeholder="Exact description of the defect"
                                autofocus
                                autocomplete="defect_description"
                            />

                            <InputError class="mt-2" :message="form.errors.exact_desc"/>
                        </div>

                        <div class="flex-initial basis-[48%]">
                            <InputLabel for="defect_reason" value="Reason for defect"/>

                            <TextArea
                                id="service_contract"
                                class="mt-1"
                                v-model="form.reason_defect"
                                placeholder="Reason for defect"

                                autofocus
                                autocomplete="defect_reason"
                            />

                            <InputError class="mt-2" :message="form.errors.reason_defect"/>
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
                                v-model="form.comment"
                                placeholder="Comment claim"

                                autofocus
                                autocomplete="comment"
                            />

                            <InputError class="mt-2" :message="form.errors.comment"/>
                        </div>
                    </Section>

                    <SectionServiceWorks
                        class="mt-4"
                        :group="selectedGroup"
                        @update:serviceworks="handleUpdateServiceWork"
                        @update:group="handleUpdateGroup"
                    />

                    <SectionSpareParts
                        class="mt-4"
                        :searchTable="form.spareparts"
                        @update:spareparts="handleUpdateSpareparts"/>


                    <div class="flex items-center gap-4 fixed bottom-12 left-12 ">
                        <PrimaryButton
                            class="md:h-16 md:w-48 h-12 w-24"
                            :disabled="form.processing">Save</PrimaryButton>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p v-if="form.recentlySuccessful" class="text-lg text-green-600">Warranty claim created successfully.</p>
                        </Transition>
                    </div>

                </form>
            </div>
        </div>
    </UserLayout>
</template>

<style scoped>

</style>
