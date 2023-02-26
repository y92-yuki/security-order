<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {ref, reactive, onMounted } from 'vue';
import InfiniteLoading from 'v3-infinite-loading';

const props = defineProps({
    products: Object
});

let comments = ref([]);
let page = 1;

const load = async $state => {
  console.log("loading...");

  try {
    const response = await fetch(
      "https://jsonplaceholder.typicode.com/comments?_limit=100&_page=" + page
    );
    const json = await response.json();

    if (json.length < 10) {
        $state.complete();
    } else {
      comments.value.push(...json);
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
                    <div v-for="product in props.products" :key="product.id" class="lg:w-1/4 md:w-1/2 p-4 w-full">
                        <a class="block relative h-48 rounded overflow-hidden">
                            <img alt="ecommerce" class="object-cover object-center w-full h-full block" src="https://dummyimage.com/420x260">
                        </a>
                        <div class="mt-4">
                            <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">
                                {{ product.manufacturer.manufacturer_name }}
                            </h3>
                            <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">
                                {{ product.category.category_name }}
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
                <InfiniteLoading @infinite="load" target="#infinitie" />
            </div>
        </section>
    </AuthenticatedLayout>
</template>