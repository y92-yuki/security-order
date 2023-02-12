<script setup>
import OwnerAuthenticatedLayout from '@/Layouts/OwnerAuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { reactive } from 'vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    manufacturer: Object,
    errors: Object,
})

const form = reactive({
    id: props.manufacturer.id,
    manufacturer_name: props.manufacturer.manufacturer_name,
    picture: null,
    other: props.manufacturer.other,
    is_picture_modify: '1',
});


const onCheckUpload = e => {
    form.picture = e.target.files[0];
}

const submit = () => {
    confirm('この内容で更新しますか？') ? router.post(route('owner.manufacturer.update'), form) : '';
}

</script>

<template>
    <Head title="管理画面 メーカー 編集" />

    <OwnerAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">メーカー 編集</h2>
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
                                            <label for="manufacturer_name" class="leading-7 text-sm text-gray-600">メーカー名</label>
                                            <InputError :message="errors.manufacturer_name" />
                                            <input type="text" v-model="form.manufacturer_name" id="manufacturer_name" name="manufacturer_name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        </div>
                                        <div class="p-2 w-full">
                                            <div>
                                                <div for="picture" class="leading-7 text-sm text-gray-600">画像添付:{{ manufacturer.picture ? '有':'無' }}</div>
                                                <input id="not_change" name="is_picture_modify" class="mr-1" value="1" type="radio" v-model="form.is_picture_modify">
                                                <label for="not_change" class="mr-5 leading-7 text-sm text-gray-600">変更しない</label>

                                                <input id="picture_modify" name="is_picture_modify" class="mr-1" value="2" type="radio" v-model="form.is_picture_modify">
                                                <label for="picture_modify" class="mr-5 leading-7 text-sm text-gray-600">画像を変更する</label>

                                                <span v-if="manufacturer.picture">
                                                    <input id="picture_delete" name="is_picture_modify" class="mr-1" value="3" type="radio" v-model="form.is_picture_modify">
                                                    <label for="picture_delete" class="mr-5 leading-7 text-sm text-gray-600">画像を削除</label>
                                                </span>
                                            </div>
                                            <div v-if="form.is_picture_modify === '2'">
                                                <InputError :message="errors.picture" />
                                                <input type="file" @change="onCheckUpload" id="picture" name="picture" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <label for="other" class="leading-7 text-sm text-gray-600">備考</label>
                                            <InputError :message="errors.other" />
                                            <textarea id="other" v-model="form.other" name="other" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                        </div>
                                        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                            更新
                                        </PrimaryButton>
                                        <Link as="button" :href="route('owner.manufacturer.show', {manufacturer: manufacturer.id})" class="ml-1 tracking-widest text-white bg-lime-600 py-2 px-4 uppercase focus:outline-none text-xs hover:bg-lime-500 rounded-md font-semibold">
                                            戻る
                                        </Link>
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
