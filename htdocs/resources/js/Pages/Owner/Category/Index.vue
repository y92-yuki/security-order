<script setup>

import OwnerAuthenticatedLayout from '@/Layouts/OwnerAuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { reactive } from 'vue';

const props = defineProps({
    categories: Object
})

const categories = [];
for(let category of props.categories) {
    categories.push(reactive({
        id: category.id,
        category_name: category.category_name,
        picture: category.picture ? 'あり' : 'なし',
        is_display: category.is_display ? true : false
    }));
}

const toggleDisplay = (key, id, is_display) => {
    const displayAttr = {
        id: id,
        is_display: is_display
    }

    if(confirm('表示設定を変更しますか?')) {
        router.post(route('owner.category.toggle_display', displayAttr));
    } else {
        categories[key].is_display = !is_display;
    }
}

</script>

<template>
    <Head title="管理画面 カテゴリー" />

    <OwnerAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">カテゴリー 一覧</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font">
                            <div class="container px-5 py-8 mx-auto">
                                <div class="flex pl-4 my-4 lg:w-2/3 w-full mx-auto">
                                    <Link as="button" :href="route('owner.category.create')" class="flex ml-auto tracking-widest text-white bg-gray-600 py-2 px-4 uppercase focus:outline-none text-xs hover:bg-gray-500 rounded-md font-semibold">登録</Link>
                                </div>
                                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                    <div v-if="!categories.length">登録しているカテゴリーはありません。</div>
                                    <table v-else class="table-auto w-full text-left whitespace-no-wrap">
                                        <thead>
                                        <tr>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">ID</th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メーカー名</th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">画像</th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">表示・非表示</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(category,key) in categories" :key="category.id">
                                                <td class="px-4 py-3">
                                                    <Link :href="route('owner.category.show', {category: category.id})">
                                                        {{ category.id }}
                                                    </Link>
                                                </td>
                                                <td class="px-4 py-3">{{ category.category_name }}</td>
                                                <td class="px-4 py-3">{{ category.picture}}</td>
                                                <td class="px-4 py-3 text-center">
                                                    <input type="checkbox" name="is_display" @change="toggleDisplay(key, category.id, category.is_display)" v-model="category.is_display">
                                                </td>
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
