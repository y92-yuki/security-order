<script setup>
import OwnerAuthenticatedLayout from '@/Layouts/OwnerAuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import nl2br from '@/nl2br';

defineProps({
    manufacturer: Object,
})

</script>

<template>
    <Head title="管理画面 メーカー 詳細" />

    <OwnerAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">メーカー 詳細</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="p-2 w-full">
                            <section class="text-gray-600 body-font">
                                <div class="container px-5 py-10 mx-auto">
                                    <div class="w-2/3 mx-auto">
                                        <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">登録</h1>
                                    </div>
                                    <div class="p-2 w-full">
                                        <label for="manufacturer_name" class="leading-7 text-sm text-gray-600">メーカー名</label>
                                        <div id="manufacturer_name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            {{ manufacturer.manufacturer_name }}
                                        </div>
                                    </div>
                                    <div class="p-2 w-full">
                                        <label for="other" class="leading-7 text-sm text-gray-600">備考</label>
                                        <div v-html="nl2br(manufacturer.other)" id="other" name="other" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></div>
                                    </div>
                                    <PrimaryButton class="ml-4">
                                        登録
                                    </PrimaryButton>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </OwnerAuthenticatedLayout>
</template>
