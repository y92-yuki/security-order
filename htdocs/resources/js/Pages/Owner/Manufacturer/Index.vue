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
                        <div class="p-2 w-full">
                            <div class="flex flex-row-reverse">
                                <Link as="button" :href="route('owner.manufacturer.create')" class="text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg">
                                    登録
                                </Link>
                            </div>
                            <div v-if="!manufacturers">登録されているメーカーがありません。</div>

                            <div v-else>メーカー 一覧</div>
                            <table class="table-fixed border w-5/6">
                            <thead class="bg-blue-200">
                                <tr>
                                    <th class="w-1/6 border">id</th>
                                    <th class="w-2/6 border">メーカー</th>
                                    <th class="w-2/6 border">画像</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="manufacturer in manufacturers" :key="manufacturer.id">
                                    <td class="border"><Link :href="route('owner.manufacturer.show', {manufacturer: manufacturer})">{{ manufacturer.id }}</Link></td>
                                    <td class="border">{{ manufacturer.manufacturer_name }}</td>
                                    <td class="border">{{ manufacturer.picture === null ? 'なし' : 'あり' }}</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </OwnerAuthenticatedLayout>
</template>
