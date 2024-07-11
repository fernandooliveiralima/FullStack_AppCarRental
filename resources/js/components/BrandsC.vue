<script setup>
/* Vue Imports */
import { computed, onMounted, reactive, ref } from 'vue';

/* App Imports */
import axios from 'axios';

/* Pinia */
import { storeToRefs } from 'pinia';
import { useBrandStore } from '../store/brandStore';
const store = useBrandStore();
const { state, transactionState } = storeToRefs(store);
/* end Pinia */

/* Variables */
const baseUrl = ref('http://localhost:8000/api/auth/brand');
const brandName = ref('');
const fileImage = ref([]);
const transactionStatus = ref('');
let transactionDetails = reactive({});
let searchBrands = reactive({ id: '', brand_name: '' });
let paginateUrl = ref('');
let filterUrl = ref('');
let allBrands = reactive({
    data: [],
    links: {},
    meta: {}
});

const brandTitles = reactive({
    id: { title: 'Id', type: 'text' },
    brand_name: { title: 'Brand Name', type: 'text' },
    brand_image: { title: 'Brand Image', type: 'image' },
    created_at: { title: 'Creation Date', type: 'date' }
});

/* Computed Properties */
const token = computed(() => {
    let tokenInstance = document.cookie.split(';').find(index => {
        return index.includes('token=');
    });
    tokenInstance = tokenInstance.split('=')[1];
    tokenInstance = `Bearer ${tokenInstance}`
    return tokenInstance;
});


/* Methods */
const loadImage = (event) => {
    fileImage.value = event.target.files;
};

const paginationElement = async (paginateEl) => {
    try {
        if (paginateEl.url) {
            paginateUrl.value = paginateEl.url.split('?')[1];

            await loadList();
        }
    } catch (error) {
        console.log(error);
    }

};


const loadList = async () => {
    try {
        let url = `${baseUrl.value}?${paginateUrl.value}${filterUrl.value}`;

        let formConfig = {
            method: 'get',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': token.value
            }
        };

        await axios.get(url, formConfig)
            .then((response) => {
                allBrands.data = response.data.data;
                allBrands.links = response.data.links;
                allBrands.meta = response.data.meta;
            });
    } catch (error) {
        console.log(error);
    }
};


const saveBrand = async () => {

    try {

        let formData = new FormData();
        formData.append('brand_name', brandName.value);
        formData.append('brand_image', fileImage.value[0]);

        let formConfig = {
            method: 'post',
            headers: {
                'Content-Type': 'multipart/form-data',
                'Accept': 'application/json',
                'Authorization': token.value
            },
            body: JSON.stringify({
                'brand_name': brandName.value,
                'brand_image': fileImage.value[0]
            })
        }

        await axios.post(baseUrl.value, formData, formConfig)
            .then((response) => {
                transactionStatus.value = 'Added Successfully';
                transactionDetails = {
                    successMessage: `The Brand Id: ${response.data.id}`
                };

            });
        await loadList();

    } catch (error) {
        transactionStatus.value = 'Added Error';
        transactionDetails = {
            errorDataMessage: error.response.data.errors
        };

    }

};


const findBrand = async () => {
    try {
        let filterItem = '';
        for (let brand in searchBrands) {
            if (searchBrands[brand]) {
                if (filterItem !== '') {
                    filterItem += ';';
                }
                filterItem += `${brand}:like:${searchBrands[brand]}`;
            }
        }
        if (filterItem !== '') {
            paginateUrl.value = 'page=1'
            filterItem = `&filter_attributes=${filterItem}`;
        } else {
            filterItem = ''
        }
        filterUrl.value = filterItem; // Atualize o valor de filterUrl
        await loadList(); // Chame loadList para atualizar a lista
    } catch (error) {
        console.log(error);
    }
};

const updateBrand = async () => {
    try {
        let formData = new FormData();
        formData.append('_method', 'patch')
        formData.append('brand_name', state.value.item.brand_name)

        if (fileImage.value[0]) {
            formData.append('brand_image', fileImage.value[0])
        }

        let url = `${baseUrl.value}/${state.value.item.id}`;

        let formConfig = {
            method: 'post',
            headers: {
                'Content-Type': 'multipart/form-data',
                'Accept': 'application/json',
                'Authorization': token.value
            }
        }

        await axios.post(url, formData, formConfig)
            .then((response) => {
                transactionState.value.transaction.status = 'Success Action';
                transactionState.value.transaction.message = 'Brand Updated Successfully';
                console.log(response);
            });

        await loadList();

    } catch (errors) {
        transactionState.value.transaction.status = 'Error Action';
        transactionState.value.transaction.message = errors.response.data.message;
        transactionState.value.transaction.errorDataMessage = errors.response.data.errors;
        console.log(errors);
    }
};

const deleteBrand = async () => {

    try {

        let confirmRemoveBrand = confirm('Are you sure you want to remove this brand?');
        if (!confirmRemoveBrand) {
            return false;
        };

        let url = `${baseUrl.value}/${state.value.item.id}`;


        let formData = new FormData();
        formData.append('_method', 'delete');

        let formConfig = {
            headers: {
                'Accept': 'application/json',
                'Authorization': token.value
            }
        }

        await axios.post(url, formData, formConfig)
            .then((response) => {
                transactionState.value.transaction.status = 'Success Action';
                transactionState.value.transaction.message = response.data.SuccessMessage;


            });

        await loadList();

    } catch (error) {

        transactionState.value.transaction.status = 'Error Action';
        transactionState.value.transaction.message = error.response.data.errorMessage;

    }
};

/* Vue Methods */
onMounted(() => {
    loadList();
});

</script>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Start Search Card -->
                <card-component>
                    <template v-slot:content>
                        <div class="card-body">

                            <input-container-component title_element="ID" id_element="inputId" idHelp="idHelp"
                                text_help="Search For Brand Id">

                                <input type="text" class="form-control" id="exampleInputBrandId"
                                    aria-describedby="idHelp" placeholder="Brand Id" v-model="searchBrands.id" />
                            </input-container-component>

                            <div class="mb-3">

                                <input-container-component title_element="Brand Name" id_element="inputName"
                                    idHelp="NameHelp" text_help="Search For Brand Name">

                                    <input type="text" class="form-control" id="exampleInputBrandName"
                                        aria-describedby="NameHelp" placeholder="Brand Name"
                                        v-model="searchBrands.brand_name" />
                                </input-container-component>

                            </div>

                            <button type="button" class="btn btn-outline-primary btn-sm float-end"
                                @click="findBrand()">Search Brand</button>

                        </div>

                    </template>


                </card-component>
                <!-- End Search Card -->


                <!-- brand list  -->
                <card-component class="mt-5" card_title="Brand List">
                    <template v-slot:content>

                        <div class="card">
                            <div class="card-header">...</div>

                            <div class="card-body">

                                <table-component :data_brands="allBrands.data" :prop_brand_titles="brandTitles"
                                    :view_brand="{ modal_visible: true, data_toggle: 'modal', data_target: '#viewBrandModal' }"
                                    :update_brand="{ modal_visible: true, data_toggle: 'modal', data_target: '#updateBrandModal' }"
                                    :delete_brand="{ modal_visible: true, data_toggle: 'modal', data_target: '#deleteBrandModal' }">

                                </table-component>

                                <button type="button" class="btn btn-outline-info btn-outline-primary btn-sm float-end "
                                    data-bs-toggle="modal" data-bs-target="#brandModal">
                                    Add Brand
                                </button>

                                <!-- Paginate Component -->
                                <paginate-component>
                                    <li v-for="(iterator, index) in allBrands.links" :key="index"
                                        :class="iterator.active ? 'page-item active' : 'page-item'"
                                        @click="paginationElement(iterator)">
                                        <a class="page-link" v-html="iterator.label"></a>
                                    </li>

                                </paginate-component>
                            </div>

                        </div>
                    </template>
                </card-component>
                <!-- end brand list  -->


            </div>
        </div>


        <!-- Button trigger modal -->

        <!-- Modal Add Brand -->
        <modal-component modal_id="brandModal" modal_title="Add Brand">

            <template v-slot:alerts>
                <alert-component v-if="transactionStatus === 'Added Successfully'" type_alert="success"
                    alert_title="Successfully inserted brand!" :alert_details="transactionDetails">
                </alert-component>

                <alert-component v-if="transactionStatus === 'Added Error'" type_alert="danger"
                    alert_title="Error When Trying To Insert The Brand!" :alert_details="transactionDetails">
                </alert-component>
            </template>

            <template v-slot:modal-content>

                <!-- Input Add Brand -->
                <input-container-component id_element="newInputName" idHelp="NewNameHelp"
                    text_help="Search For Brand Name">

                    <input type="text" class="form-control" id="exampleInputBrandName" aria-describedby="NewNameHelp"
                        placeholder="Brand Name" v-model="brandName" />
                </input-container-component>
                
                <!-- Input Add Brand -->

                <!-- Input Id Brand -->
                <input-container-component id_element="newInputId" idHelp="NewImageHelp"
                    text_help="Select PNG Brand Image">

                    <input type="file" class="form-control" id="exampleInputBranImage" aria-describedby="NewImageHelp"
                        placeholder="Select The Brand Image" @change="loadImage($event)" />
                </input-container-component>
                
                <!-- Input Id Brand -->
            </template>

            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" @click="saveBrand()">Save Brand</button>
            </template>
        </modal-component>
        <!-- End Modal Add Brand -->


        <!-- Modal View Brand -->
        <modal-component modal_id="viewBrandModal" modal_title="View Brand">
            <template v-slot:alerts></template>
            <template v-slot:modal-content>

                <input-container-component>
                    <input type="text" name="" id="brand_id_view" :value="state.item.id" disabled />
                </input-container-component>

                <input-container-component>
                    <input type="text" name="" id="brand_name_view" :value="state.item.brand_name" disabled />
                </input-container-component>

                <input-container-component>
                    <span>Image:</span> <img v-if="state.item.brand_image" :src="`storage/${state.item.brand_image}`"
                        alt="">
                </input-container-component>

                <input-container-component>
                    <input type="text" name="" id="brand_creation_view" :value="state.item.created_at" disabled />
                </input-container-component>

            </template>

            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </template>
        </modal-component>
        <!-- End Modal View Brand -->


        <!-- Modal delete Brand -->

        <modal-component modal_id="deleteBrandModal" modal_title="delete Brand">
            <template v-slot:alerts>
                <alert-component v-if="transactionState.transaction.status === 'Success Action'" type_alert="success"
                    alert_title="Transaction Completed Successfully"
                    :alert_details="transactionState.transaction"></alert-component>
                <alert-component v-if="transactionState.transaction.status === 'Error Action'" type_alert="danger"
                    alert_title="Transaction Error" :alert_details="transactionState.transaction"></alert-component>
            </template>
            <template v-slot:modal-content v-if="transactionState.transaction.status !== 'Success Action'">
                <input-container-component>
                    <input type="text" id="brand_id_delete" :value="state.item.id" disabled />
                </input-container-component>
                <input-container-component>
                    <input type="text" id="brand_name_delete" :value="state.item.brand_name" disabled />
                </input-container-component>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-danger" @click="deleteBrand()"
                    v-if="transactionState.transaction.status !== 'Success Action'">
                    Delete Brand
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
            </template>
        </modal-component>

        <template>

        </template>

        <!-- End Modal delete Brand -->

        <!-- Modal Update Brand -->

        <modal-component modal_id="updateBrandModal" modal_title="Update Brand">

            <template v-slot:alerts>
                <alert-component v-if="transactionState.transaction.status === 'Success Action'" type_alert="success"
                    alert_title="Transaction Completed Successfully"
                    :alert_details="transactionState.transaction"></alert-component>
                <alert-component v-if="transactionState.transaction.status === 'Error Action'" type_alert="danger"
                    alert_title="Transaction Error" :alert_details="transactionState.transaction"></alert-component>
            </template>

            <template v-slot:modal-content>

                <!-- Input Add Brand -->
                <input-container-component id_element="updateNewInputName" idHelp="NewUpdateNameHelp"
                    text_help="Search For Brand Name">

                    <input type="text" class="form-control" id="exampleInputBrandName"
                        aria-describedby="NewUpdateNameHelp" placeholder="Brand Name" v-model="state.item.brand_name" />
                </input-container-component>
                
                <!-- Input Add Brand -->

                <!-- Input Id Brand -->
                <input-container-component id_element="newUpdateInputId" idHelp="NewUpdateImageHelp"
                    text_help="Select PNG Brand Image">

                    <input type="file" class="form-control" id="exampleUpdateInputBranImage"
                        aria-describedby="NewUpdateImageHelp" placeholder="Select The Brand Image"
                        @change="loadImage($event)" />
                </input-container-component>
                {{ fileImage }}
                <!-- Input Id Brand -->
                
            </template>

            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" @click="updateBrand()">Update Brand</button>
            </template>
        </modal-component>

        <!-- End Modal Update Brand -->

    </div>
</template>

<style scoped></style>