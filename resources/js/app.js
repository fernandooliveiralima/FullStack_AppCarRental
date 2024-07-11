/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});
const pinia = createPinia();

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

import LoginC from './components/LoginC.vue';
app.component('login-component', LoginC);

import HomeC from './components/HomeC.vue';
app.component('home-component', HomeC);

import BrandsC from './components/BrandsC.vue';
app.component('brands-component', BrandsC);

import InputContainerC from './components/InputContainerC.vue';
app.component('input-container-component', InputContainerC);

import TableC from './components/TableC.vue';
app.component('table-component', TableC);

import CardC from './components/CardC.vue';
app.component('card-component', CardC)

import ModalC from './components/ModalC.vue';
app.component('modal-component', ModalC)

import AlertC from './components/AlertC.vue';
app.component('alert-component', AlertC)

import PaginateC from './components/PaginateC.vue';
app.component('paginate-component', PaginateC)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */



app.use(pinia);
app.mount('#app');
