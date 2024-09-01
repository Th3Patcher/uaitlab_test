<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router, usePage, Link} from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import {ref, computed, watch} from 'vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import api from "@/api.js";

const props = defineProps( {
    users: Object,
    search: String,
});
console.log(props.users);
let a;
// const test = api.get('/warranty_claims/search')
//     .then(response => {
//         console.log(response);
//     }).catch(error => {
//         console.log(error);
//     });


let search = ref(usePage().props.search),
    pageNumber = ref(1);

let usersUrl = computed(() => {
    let url = new URL(route("users.list"));
    url.searchParams.append("page", pageNumber.value);

    if (pageNumber.value > props.users.meta.last_page) {
        url.searchParams.set("page", props.users.meta.last_page);
    }

    if (search.value) {
        url.searchParams.append("search", search.value);
    }

    return url;
})

const updatedPageNumber = (link) => {
    pageNumber.value = link.url.split("=")[1];
};

watch(() => usersUrl.value,
    (newUrl) => {
        router.visit(newUrl, {
            preserveScroll: true,
            preserveState: true,
            replace: true
        });
    });

</script>

<template>
    <Head title="Users"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Users</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="relative overflow-x-auto rounded-xl shadow-lg">
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
                        <Link :href="route('users.create')">
                            <PrimaryButton
                                    class="flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1 mb-0.5" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path
                                        d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                                </svg>
                                Add new user
                            </PrimaryButton>
                        </Link>
                    </div>
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Id
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="user in users.data" :key="user.id" class="bg-white border-b">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ user.id }}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ user.email }}
                            </th>
                            <td class="px-6 py-4">
                                {{ user.name }}
                            </td>

                        </tr>
                        </tbody>
                    </table>
                    <Pagination :pagination="users.meta" :updatedPageNumber="updatedPageNumber"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
