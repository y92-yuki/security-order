<script setup>
import OwnerAuthenticatedLayout from '@/Layouts/OwnerAuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { ref, reactive } from 'vue';

const props = defineProps({
    manufacturer: Object,
    picture: String
})

const show   = ref(false);
let products = [];

const displayRelationItems = async () => {
    const response = await axios.get(route('api.manufacturer.get_relation_item_list', {id: props.manufacturer.id}));
    
    for(let product of response.data) {
        products.push(reactive({
            id        : product.id,
            name      : product.product_name,
            price     : product.price.toLocaleString(),
            picture   : product.picture ? 'あり' : 'なし',
            is_selling: product.is_selling ? true : false
        }))
    }

    show.value = !show.value;
}

const closeModal = () => {
    products   = [];
    show.value = !show.value;
}

const toggleSelling = (key, id, is_selling) => {
    const sellingAttr = {
        id: id,
        is_selling: is_selling,
        manufacturer_id: props.manufacturer.id
    }

    if(confirm('販売ステータスを変更しますか?')) {
        router.post(route('owner.product.toggle_selling', sellingAttr))
    } else {
        products[key].is_selling = !is_selling;
    }
}


const deleteSubmit = () => {
    const deleteManufacturer = {
        id: props.manufacturer.id
    }

    const messageInputedUser = prompt('メーカーの削除を実行するには「完全に削除」と入力してください。');
    if(messageInputedUser !== '完全に削除') {
        return
    }

    const confirmMessage = 'メーカーを削除すると関連している商品も削除されます。\n 本当に削除しますか?';
    if(!confirm(confirmMessage)) {
        return
    }

    router.post(route('owner.manufacturer.destroy'), deleteManufacturer);
}

</script>

<template>
    <Head title="管理画面 メーカー 詳細" />

    <OwnerAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">メーカー 詳細</h2>
        </template>

        <Modal :show="show" @close="closeModal">
            <div v-if="!products.length" class="text-center py-5">登録している商品はありません。</div>
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
        </Modal>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="p-2 w-full">
                            <section class="text-gray-600 body-font">
                                <div class="container px-5 py-10 mx-auto">
                                    <button @click="displayRelationItems">関連商品</button>
                                    <div class="p-2 w-full">
                                        <label for="manufacturer_name" class="leading-7 text-sm text-gray-600">メーカー名</label>
                                        <div id="manufacturer_name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            {{ manufacturer.manufacturer_name }}
                                        </div>
                                    </div>
                                    <div class="p-2 w-full">
                                        <label for="other" class="leading-7 text-sm text-gray-600">備考</label>
                                        <textarea v-model="props.manufacturer.other" disabled id="other" name="other" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out" />
                                    </div>
                                    <div class="flex flex-col text-center w-full mb-8">
                                        <img :src="picture" class="w-1/3 mx-auto">
                                    </div>
                                    <Link as="button" :href="route('owner.manufacturer.edit', {manufacturer: manufacturer.id})" class="ml-1 tracking-widest text-white bg-gray-600 py-2 px-4 uppercase focus:outline-none text-xs hover:bg-gray-500 rounded-md font-semibold">
                                        編集
                                    </Link>
                                    <Link as="button" :href="route('owner.manufacturer.index')" class="ml-1 tracking-widest text-white bg-lime-600 py-2 px-4 uppercase focus:outline-none text-xs hover:bg-lime-500 rounded-md font-semibold">
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
