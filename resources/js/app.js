/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
/* Trae Axios */
require('./bootstrap');

window.Vue = require('vue');
//importacion de libreria Vue Router
import VueRouter from "vue-router";
Vue.use(VueRouter);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('navbarheader', require('./components/panelAdmin/navbarHeader.vue').default);
Vue.component('sidebardleft', require('./components/panelAdmin/sidebardLeft.vue').default);
Vue.component('sidebardright', require('./components/panelAdmin/sidebardRight.vue').default);

//----*********** Aqui agregaremos todo configurado con Vue-Router*********
// 0. If using a module system (e.g. via vue-cli), import Vue and VueRouter
// and then call `Vue.use(VueRouter)`.

// 1. Define route components.
// These can be imported from other files
const Error404 = require("./components/Error404.vue").default;
//para el Admin
const Escritorio = require("./components/allMenusInfo/Escritorio.vue").default;
const Colors = require("./components/allMenusInfo/Colors.vue").default;
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// 2. Define some routes
// Each route should map to a component. The "component" can
// either be an actual component constructor created via
// `Vue.extend()`, or just a component options object.
// We'll talk about nested routes later.
const routes = [{
        path: "*",
        component: Error404
    },
    {
        path: "/",
        component: Escritorio
    },
    {
        path: "/colors",
        component: Colors
    },
];

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter({
    //mode: 'history',//quitando el hash # que viene por defecto con vue-router
    routes, // short for `routes: routes`
    base: "/admin"
});

const app = new Vue({
    el: '#app',
    router
});
