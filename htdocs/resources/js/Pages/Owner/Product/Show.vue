<script setup>
import OwnerAuthenticatedLayout from '@/Layouts/OwnerAuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import nl2br from '@/nl2br';

const props = defineProps({
    product: Object,
    picture: String
})

const deleteSubmit = () => {
    const deletePost = {
        id: props.product.id
    }
    confirm('商品を削除しますか?') ? router.post(route('owner.product.destroy'), deletePost) : null;
}

if (props.product.memo) {
    props.product.memo = nl2br(props.product.memo);
}

</script>

<template>
    <Head title="管理画面 商品 詳細" />

    <OwnerAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品 詳細</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="p-2 w-full">
                            <section class="text-gray-600 body-font">
                                <div class="container px-5 py-10 mx-auto">
                                    <div class="p-2 w-full">
                                        <label for="manufacturer_name" class="leading-7 text-sm text-gray-600">メーカー</label>
                                        <div id="manufacturer_name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            {{ product.manufacturer.manufacturer_name }}
                                        </div>
                                    </div>
                                    <div class="p-2 w-full">
                                        <label for="category_name" class="leading-7 text-sm text-gray-600">カテゴリー</label>
                                        <div id="category_name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            {{ product.category.category_name }}
                                        </div>
                                    </div>
                                    <div class="p-2 w-full">
                                        <label for="product_name" class="leading-7 text-sm text-gray-600">商品名</label>
                                        <div id="product_name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            {{ product.product_name }}
                                        </div>
                                    </div>
                                    <div class="p-2 w-full">
                                        <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                                        <div v-html="props.product.memo" id="memo" name="memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></div>
                                    </div>
                                    <div class="flex flex-col text-center w-full mb-8">
                                        <img :src="picture" class="w-1/3 mx-auto">
                                    </div>
                                    <Link as="button" :href="route('owner.product.edit', {id: product.id})" class="ml-1 tracking-widest text-white bg-gray-600 py-2 px-4 uppercase focus:outline-none text-xs hover:bg-gray-500 rounded-md font-semibold">
                                        編集
                                    </Link>
                                    <Link as="button" :href="route('owner.product.index')" class="ml-1 tracking-widest text-white bg-lime-600 py-2 px-4 uppercase focus:outline-none text-xs hover:bg-lime-500 rounded-md font-semibold">
                                        戻る
                                    </Link>
                                    <div class="text-right">
                                        <button @click="deleteSubmit" class="ml-1 tracking-widest text-white bg-red-600 py-2 px-4 uppercase focus:outline-none text-xs hover:bg-red-500 rounded-md font-semibold">
                                            削除
                                        </button>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </OwnerAuthenticatedLayout>
</template>
