<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {ref, reactive, onMounted } from 'vue';
import InfiniteLoading from 'v3-infinite-loading';
import axios from 'axios';
import {  DotLoader  } from "vue3-spinner";

const products = ref([]);
let page = 1;

const load = async $state => {
  try {
    const response = await axios.get(route('api.shopping.product.index', {page: page}));
    for(let product of response.data) {
        products.value.push({
          id                : product.id,
          manufacturer_name : product.manufacturer.manufacturer_name,
          category_name     : product.category.category_name,
          product_name      : product.product_name,
          price             : product.price,
          picture           : product.picture,
        });
    }

    if (response.data.length < 50) {
        $state.complete();
    } else {
      $state.loaded();
    }

    page++;
  } catch (error) {
    $state.error();
  }
};

</script>

<template>
    <Head title="Security Order" />

    <AuthenticatedLayout>
        <template #header>Security Order</template>

        <section class="text-gray-600 body-font">
            <div class="container px-5 py-24 mx-auto">
                <div class="flex flex-wrap -m-4">
                    <div v-for="product in products" :key="product.id" class="lg:w-1/4 md:w-1/2 p-4 w-full">
                        <a class="block relative h-48 rounded overflow-hidden">
                            <img alt="ecommerce" class="object-cover object-center w-full h-full block" src="https://dummyimage.com/420x260">
                        </a>
                        <div class="mt-4">
                            <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">
                                {{ product.manufacturer_name }}
                            </h3>
                            <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">
                                {{ product.category_name }}
                            </h3>
                            <h2 class="text-gray-900 title-font text-lg font-medium">
                                {{ product.product_name }}
                            </h2>
                            <p class="mt-1">¥{{ product.price.toLocaleString() }}</p>
                            <span class="flex flex-row-reverse">
                                <button type="button">詳細</button>
                            </span>
                        </div>
                    </div>
                </div>
                <InfiniteLoading @infinite="load" class="my-5 flex justify-center">
                    <template #spinner><DotLoader /></template>
                    <template #complete>全て表示しました</template>
                </InfiniteLoading>
            </div>
        </section>
    </AuthenticatedLayout>
</template>