<script setup>
import OwnerAuthenticatedLayout from '@/Layouts/OwnerAuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { reactive } from 'vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    errors: Object,
    categories: Object,
    manufacturers: Object
})

const form = reactive({
    manufacturer_id: props.manufacturers.length ? props.manufacturers[0].id : null,
    category_id: props.categories.length ? props.categories[0].id : null,
    product_name: null,
    price: 0,
    picture: null,
    memo: null
});

const onCheckUpload = e => {
    form.picture = e.target.files[0];
}

const submit = () => {
    confirm('この内容で登録しますか？') ? router.post(route('owner.product.store'), form) : '';
}

</script>

<template>
    <Head title="管理画面 商品 登録" />

    <OwnerAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品 登録</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="p-2 w-full">
                            <section class="text-gray-600 body-font">
                                <div class="container px-5 py-10 mx-auto">
                                    <form @submit.prevent="submit" class="md:w-2/3 mx-auto">
                                        <div class="p-2 w-full">
                                            <label for="manufacturer_id" class="leading-7 text-sm text-gray-600">メーカー*</label>
                                            <div v-if="!form.manufacturer_id">
                                                <Link class="text-red-600" :href="route('owner.manufacturer.index')">※メーカーを登録してください。</Link>
                                            </div>
                                            <InputError :message="errors.manufacturer_id" />
                                            <select id="manufacturer_id" name="manufacturer_id" v-model="form.manufacturer_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <option v-for="manufacturer in manufacturers" :value="manufacturer.id" :key="manufacturer.id">
                                                    {{ manufacturer.manufacturer_name }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="p-2 w-full">
                                            <label for="category_id" class="leading-7 text-sm text-gray-600">カテゴリー*</label>
                                            <div v-if="!form.category_id">
                                                <Link class="text-red-600" :href="route('owner.manufacturer.index')">※カテゴリーを登録してください。</Link>
                                            </div>
                                            <InputError :message="errors.category_id" />
                                            <select id="category_id" name="category_id" v-model="form.category_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <option v-for="category in categories" :value="category.id" :key="category.id">
                                                    {{ category.category_name }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="p-2 w-full">
                                            <label for="product_name" class="leading-7 text-sm text-gray-600">商品名*</label>
                                            <InputError :message="errors.product_name" />
                                            <input type="text" v-model="form.product_name" id="product_name" name="product_name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        </div>
                                        <div class="p-2 w-full">
                                            <label for="price" class="leading-7 text-sm text-gray-600">価格*</label>
                                            <InputError :message="errors.price" />
                                            <input type="number" v-model="form.price" id="price" name="price" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        </div>
                                        <div class="p-2 w-full">
                                            <label for="picture" class="leading-7 text-sm text-gray-600">画像</label>
                                            <InputError :message="errors.picture" />
                                            <input type="file" @change="onCheckUpload" id="picture" name="picture" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        </div>
                                        <div class="p-2 w-full">
                                            <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                                            <InputError :message="errors.memo" />
                                            <textarea id="memo" v-model="form.memo" name="memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                        </div>
                                        <PrimaryButton v-if="form.manufacturer_id && form.category_id" class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                            登録
                                        </PrimaryButton>
                                    </form>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </OwnerAuthenticatedLayout>
</template>
