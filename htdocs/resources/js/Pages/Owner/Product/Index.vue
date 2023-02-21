<script setup>
import OwnerAuthenticatedLayout from '@/Layouts/OwnerAuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';
import Pagination from '@/Components/Pagination.vue';
import Modal from '@/Components/Modal.vue';
import axios from 'axios';

const props = defineProps({
    products: Object
})

// 一覧表示用
const products = [];
for(let product of props.products.data) {
    products.push(reactive({
        id        : product.id,
        price     : product.price.toLocaleString(),
        name      : product.product_name,
        picture   : product.picture ? 'あり' : 'なし',
        is_selling: product.is_selling ? true : false
    }))
}

// 商品検索用
const show = ref(false);
const search = ref('');
let searchProducts = ref([]);
const searchSubmit = async () => {
    try {
        const response = await axios.get(route('api.product.search', {search: search.value}));
        for(let product of response.data) {
            searchProducts.value.push({
                id        : product.id,
                name      : product.product_name,
                price     : product.price.toLocaleString(),
                picture   : product.picture ? 'あり' : 'なし',
                is_selling: product.is_selling ? true : false
            })
    
        }
        
        show.value = !show.value;
        
    } catch(e) {
        console.error(e)
    }
}

const closeModal = () => {
    searchProducts = ref([]);
    search.value   = '';
    show.value     = !show.value
}

const toggleSelling = (key, id, is_selling) => {
    const sellingAttr = {
        id: id,
        is_selling: is_selling,
        page: props.products.current_page
    }

    // 選択された商品が一覧表示に存在するかどうか
    let indexScreenProduct = null;
    for(let product of products) {
        if(product.id === id) {
            indexScreenProduct = product;
        }
    }

    if(confirm('販売ステータスを変更しますか?')) {
        if(indexScreenProduct) {
            indexScreenProduct.is_selling = is_selling
        }
        router.post(route('owner.product.toggle_selling', sellingAttr))
    } else {
        // 一覧表示されている商品
        if(indexScreenProduct) {
            indexScreenProduct.is_selling = !is_selling;
        }
        // モーダルウィンドウに表示されている商品
        if(searchProducts.value.length) {
            searchProducts.value[key].is_selling = !is_selling;
        }
    }
}

</script>

<template>
    <Head title="管理画面 商品" />

    <OwnerAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品 一覧</h2>
        </template>

        <Modal :show="show" @close="closeModal">
            <div v-if="!searchProducts.length" class="text-center py-5">登録している商品はありません。</div>
            <table v-else class="table-auto w-full text-left whitespace-no-wrap">
                <thead>
                <tr>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">ID</th>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">商品名</th>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">価格</th>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">画像</th>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">販売ステータス</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="(product,key) in searchProducts" :key="product.id">
                        <td class="px-4 py-3">
                            <Link :href="route('owner.product.show', {id: product.id})">
                                {{ product.id }}
                            </Link>
                        </td>
                        <td class="px-4 py-3">{{ product.name }}</td>
                        <td class="px-4 py-3">¥{{ product.price }}</td>
                        <td class="px-4 py-3">{{ product.picture}}</td>
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox" name="is_selling" @change="toggleSelling(key, product.id, product.is_selling)" v-model="product.is_selling">
                        </td>
                    </tr>
                </tbody>
            </table>
        </Modal>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font">
                            <div class="container px-5 py-8 mx-auto">
                                <div class="text-right">
                                    <input
                                        type="text"
                                        id="product_name"
                                        name="product_name"
                                        v-model="search"
                                        class="bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-0 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                    >
                                    <button
                                        @click="searchSubmit"
                                        class="tracking-widest text-xs text-white bg-green-600 ml-1 py-2 px-4 uppercase focus:outline-none hover:bg-green-500 rounded-md font-semibold"
                                    >
                                        検索
                                    </button>
                                </div>
                                <div class="pl-4 my-4 lg:w-2/3 w-full mx-auto">
                                    <Link
                                        as="button"
                                        :href="route('owner.product.create')"
                                        class="ml-auto tracking-widest text-white bg-gray-600 py-2 px-4 uppercase focus:outline-none text-xs hover:bg-gray-500 rounded-md font-semibold"
                                    >
                                        登録
                                    </Link>
                                </div>
                                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                    <div v-if="!products.length">登録している商品はありません。</div>
                                    <table v-else class="table-auto w-full text-left whitespace-no-wrap">
                                        <thead>
                                        <tr>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">ID</th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">商品名</th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">価格</th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">画像</th>
                                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 text-center">販売ステータス</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(product,key) in products" :key="product.id">
                                                <td class="px-4 py-3">
                                                    <Link :href="route('owner.product.show', {id: product.id})">
                                                        {{ product.id }}
                                                    </Link>
                                                </td>
                                                <td class="px-4 py-3">{{ product.name }}</td>
                                                <td class="px-4 py-3">¥{{ product.price }}</td>
                                                <td class="px-4 py-3">{{ product.picture}}</td>
                                                <td class="px-4 py-3 text-center">
                                                    <input type="checkbox" name="is_selling" @change="toggleSelling(key, product.id, product.is_selling)" v-model="product.is_selling">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="flex justify-center">
                                    <Pagination class="mt-6" :links="props.products.links" />
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </OwnerAuthenticatedLayout>
</template>
