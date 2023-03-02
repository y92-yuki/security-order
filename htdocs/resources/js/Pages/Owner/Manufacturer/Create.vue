<script setup>
import OwnerAuthenticatedLayout from '@/Layouts/OwnerAuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { reactive } from 'vue';
import InputError from '@/Components/InputError.vue';

defineProps({
  errors: Object,
})

const form = reactive({
  manufacturer_name: null,
  picture: null,
  other: null
});

const onCheckUpload = e => {
  form.picture = e.target.files[0];
}

const submit = () => {
  confirm('この内容で登録しますか？') ? router.post(route('owner.manufacturer.store'), form) : '';
}

</script>

<template>
  <Head title="管理画面 メーカー 登録" />

  <OwnerAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">メーカー 登録</h2>
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
                      <label for="manufacturer_name" class="leading-7 text-sm text-gray-600">メーカー名*</label>
                      <InputError :message="errors.manufacturer_name" />
                      <input type="text" v-model="form.manufacturer_name" id="manufacturer_name" name="manufacturer_name"
                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="p-2 w-full">
                      <label for="picture" class="leading-7 text-sm text-gray-600">画像</label>
                      <InputError :message="errors.picture" />
                      <input type="file" @change="onCheckUpload" id="picture" name="picture"
                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="p-2 w-full">
                      <label for="other" class="leading-7 text-sm text-gray-600">備考</label>
                      <InputError :message="errors.other" />
                      <textarea id="other" v-model="form.other" name="other"
                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                    </div>
                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
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
  </OwnerAuthenticatedLayout></template>
