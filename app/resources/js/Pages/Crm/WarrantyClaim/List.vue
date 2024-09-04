<script setup>
import {Head, Link} from '@inertiajs/vue3';
import {onMounted} from "vue";
import UserLayout from "@/Layouts/UserLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    token: {
        type: String,
        required: false
    }
});

onMounted(() => {
    if (props.token) {
        localStorage.setItem('token', props.token);
    }
});

</script>

<template>
    <Head title="Warranty claims" />

    <UserLayout>
        <template #header>
            <div class="flex flex-row justify-between items-center align-middle">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight inline-block">Warranty claims</h2>
                <Link :href="route('warranty-claims.create')">
                    <PrimaryButton class="">
                        Create claim
                    </PrimaryButton>
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">Table here!</div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>
