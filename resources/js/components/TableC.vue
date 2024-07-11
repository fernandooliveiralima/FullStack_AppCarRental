<script setup>
/* Vue Imports */
import { computed } from 'vue';

/* App Imports */
import dayjs from 'dayjs';

/* Pinia */
import { storeToRefs } from 'pinia';
import { useBrandStore } from '../store/brandStore';
const store = useBrandStore();
const { transactionState } = storeToRefs(store);
/* end Pinia */

/* Variables */
const currentDate = dayjs();


/* Props */
const props = defineProps({
    data_brands: {
        type: Object
    },
    prop_brand_titles: {
        type: Object
    },
    view_brand: { type: Object },
    update_brand: { type: Object },
    delete_brand: { type: Object }
});

/* Computed Properties */

const dataFormatedEnglish = computed(() => currentDate.format('YYYY-MM-DD'));

const filteredData = computed(() => {
    console.log(props.data_brands);
    let brandFields = Object.keys(props.prop_brand_titles);
    let filterDataItems = [];

    props.data_brands.forEach((item) => {
        let filteredItem = {};

        brandFields.forEach((field) => {
            filteredItem[field] = item[field];
        });

        filterDataItems.push(filteredItem);
    });

    return filterDataItems;
});

/* Methods */
const setItemStore = (itemStore) => {
    transactionState.value.transaction.status = '';
    transactionState.value.transaction.message = '';
    transactionState.value.transaction.errorDataMessage = '';
    return store.setItem(itemStore);
};

</script>

<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="(iterator, index) in props.prop_brand_titles" :key="index">
                        {{ iterator.title }}
                    </th>
                    <th v-if="props.view_brand.modal_visible || props.update_brand.modal_visible || props.delete_brand.modal_visible">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(iterator, index) in filteredData" :key="index">
                    <td v-for="(brandIterator, brandIndex) in iterator" :key="brandIndex">
                        <span v-if="props.prop_brand_titles[brandIndex].type === 'text'">{{ brandIterator }}</span>
                        <span v-if="props.prop_brand_titles[brandIndex].type === 'image'">
                            <img :src="`/storage/${brandIterator}`" alt="">
                        </span>
                        <span v-if="props.prop_brand_titles[brandIndex].type === 'date'">{{ `${dataFormatedEnglish}`}}</span>
                    </td>
                    <td>
                        <button v-if="props.view_brand.modal_visible" type="button"
                            class="btn btn-outline-primary btn-sm mx-2" 
                            :data-bs-toggle="props.view_brand.data_toggle"
                            :data-bs-target="props.view_brand.data_target" 
                            @click="setItemStore(iterator)">
                            View
                        </button>

                        <button v-if="props.update_brand.modal_visible" type="button"
                            class="btn btn-outline-warning btn-sm "
                            :data-bs-toggle="props.update_brand.data_toggle"
                            :data-bs-target="props.update_brand.data_target" 
                            @click="setItemStore(iterator)">
                            Update
                        </button>

                        <button v-if="props.delete_brand.modal_visible" type="button"
                            class="btn btn-outline-danger btn-sm mx-2"
                            :data-bs-toggle="props.delete_brand.data_toggle"
                            :data-bs-target="props.delete_brand.data_target"
                            @click="setItemStore(iterator)">
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        
    </div>
</template>


<style scoped></style>