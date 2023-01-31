<script setup>
import OwnerAuthenticatedLayout from '@/Layouts/OwnerAuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    manufacturers: Object
})

</script>

<template>
    <Head title="管理画面 メーカー" />

    <OwnerAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">メーカー 一覧</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font">
                            <div class="container px-5 py-8 mx-auto">
                                <div class="flex flex-col text-center w-full mb-8">
                                    <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">メーカー</h1>
                                </div>
                                <div class="flex pl-4 my-4 lg:w-2/3 w-full mx-auto">
                                    <Link as="button" :href="route('owner.manufacturer.create')" class="flex ml-auto text-white bg-gray-500 border-0 py-2 px-6 focus:outline-none hover:bg-gray-600 rounded">登録</Link>
                                </div>
                                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                    <table class="table-auto w-full text-left whitespace-no-wrap">
                                        <thead>
                                        <tr>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">ID</th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メーカー名</th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">画像</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="manufacturer in manufacturers" :key="manufacturer.id">
                                                <td class="px-4 py-3">
                                                    <Link :href="route('owner.manufacturer.show', {manufacturer: manufacturer.id})">{{ manufacturer.id }}</Link>
                                                </td>
                                                <td class="px-4 py-3">{{ manufacturer.manufacturer_name }}</td>
                                                <td class="px-4 py-3">{{ manufacturer.picture ? 'あり' : 'なし' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </OwnerAuthenticatedLayout>
</template>
