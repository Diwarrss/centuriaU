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

//para el vue datepicker
import Datetime from "vue-datetime";
Vue.use(Datetime);
// You need a specific loader for CSS files
import "vue-datetime/dist/vue-datetime.css";

Vue.component(
    "navbarheader",
    require("./components/panelAdmin/navbarHeader.vue").default
);
//menus para roles
Vue.component(
    "sidebardsuperadmin",
    require("./components/panelAdmin/menus/sidebardSuperadmin.vue").default
);
Vue.component(
    "sidebardadmin",
    require("./components/panelAdmin/menus/sidebardAdmin.vue").default
);
Vue.component(
    "sidebardingreso",
    require("./components/panelAdmin/menus/sidebardIngreso.vue").default
);
Vue.component(
    "sidebardconsulta",
    require("./components/panelAdmin/menus/sidebardConsulta.vue").default
);

Vue.component(
    "sidebardright",
    require("./components/panelAdmin/sidebardRight.vue").default
);
//crear personas mmodal etc
Vue.component(
    "crearpersona",
    require("./components/allMenusInfo/CrearPersona.vue").default
);
//componente grafico de ingresos vs programas actuales
Vue.component(
    "chartingresos",
    require("./components/allMenusInfo/apexCharts/chartIngresos.vue").default
);

Vue.component(
    "chartingresosmes",
    require("./components/allMenusInfo/apexCharts/chartIngresosMes.vue").default
);
//crear personas mmodal etc
/* Vue.component(
    "ingresostotales",
    require("./components/allMenusInfo/IngresosTotales.vue").default
); */

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
const Reportes = require("./components/allMenusInfo/Reportes.vue")
    .default;
const Usuarios = require("./components/allMenusInfo/Usuarios.vue").default;
const Universidad = require("./components/allMenusInfo/Universidad.vue")
    .default;
const Perfil = require("./components/allMenusInfo/Perfil.vue").default;

// 2. Define some routes
const routes = [{
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
        path: "/reportes",
        component: Reportes
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
const router = new VueRouter({
    //mode: 'history', //quitando el hash # que viene por defecto con vue-router
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
        getUserAuth: async function ({
            commit
        }) {
            const data = await fetch("/getUserAuth");
            const dataUser = await data.json(); //no es necesario pasarlo a json laravel ya lo envia en este formato
            commit("llenarInfo", dataUser);
        },
        getPeriodo: async function ({
            commit
        }) {
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
