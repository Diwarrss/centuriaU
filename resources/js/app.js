/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
/* Trae Axios */
require("./bootstrap");

window.Vue = require("vue");
//importacion de libreria Vue Router
import VueRouter from "vue-router";
Vue.use(VueRouter);

//importando VUEX
import Vuex from "vuex";
Vue.use(Vuex);

//import vue-moment CONFIGURADO AL ESPAÑOL
const moment = require("moment");
require("moment/locale/es");
Vue.use(require("vue-moment"), {
    moment
});

//import vue-select
import vSelect from "vue-select";
Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);
Vue.component(
    "navbarheader",
    require("./components/panelAdmin/navbarHeader.vue").default
);
Vue.component(
    "sidebardleft",
    require("./components/panelAdmin/sidebardLeft.vue").default
);
Vue.component(
    "sidebardright",
    require("./components/panelAdmin/sidebardRight.vue").default
);

//LLAMAMOS EL COMPONENTE DE VUE PAGINATION
Vue.component("pagination", require("laravel-vue-pagination"));

//----*********** Aqui agregaremos todo configurado con Vue-Router*********
// 0. If using a module system (e.g. via vue-cli), import Vue and VueRouter
// and then call `Vue.use(VueRouter)`.

// 1. Define route components.
// These can be imported from other files
const Error404 = require("./components/Error404.vue").default;
//para el Admin
const Escritorio = require("./components/allMenusInfo/Escritorio.vue").default;
const Ingresos = require("./components/allMenusInfo/Ingresos.vue").default;
const Personas = require("./components/allMenusInfo/Personas.vue").default;
const Computadores = require("./components/allMenusInfo/Computadores.vue")
    .default;
const Usuarios = require("./components/allMenusInfo/Usuarios.vue").default;
const Universidad = require("./components/allMenusInfo/Universidad.vue")
    .default;
const Perfil = require("./components/allMenusInfo/Perfil.vue").default;
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
const routes = [
    {
        path: "*",
        component: Error404
    },
    {
        path: "/",
        component: Escritorio
    },
    {
        path: "/ingresos",
        component: Ingresos
    },
    {
        path: "/personas",
        component: Personas
    },
    {
        path: "/computadores",
        component: Computadores
    },
    {
        path: "/usuarios",
        component: Usuarios
    },
    {
        path: "/universidad",
        component: Universidad
    },
    {
        path: "/perfil",
        component: Perfil
    }
];

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter({
    //mode: 'history',//quitando el hash # que viene por defecto con vue-router
    routes, // short for `routes: routes`
    base: "/admin"
});

//para Vuex funcione
const store = new Vuex.Store({
    state: {
        infoUserAuth: [],
        infoPeriodo: []
    },
    mutations: {
        //capturamos el dato enviado desde actions getUserAuth
        llenarInfo(state, getUserAccion) {
            state.infoUserAuth = getUserAccion;
        },
        llenarPeriodo(state, getPeriodoAccion) {
            state.infoPeriodo = getPeriodoAccion;
        }
    },
    actions: {
        getUserAuth: async function({ commit }) {
            const data = await fetch("/getUserAuth");
            const dataUser = await data.json(); //no es necesario pasarlo a json laravel ya lo envia en este formato
            commit("llenarInfo", dataUser);
        },
        getPeriodo: async function({ commit }) {
            const datos = await fetch("/getPeriodo");
            const dataPeriodo = await datos.json(); //no es necesario pasarlo a json laravel ya lo envia en este formato
            commit("llenarPeriodo", dataPeriodo);
        }
    }
});

const app = new Vue({
    el: "#app",
    router,
    store
});
