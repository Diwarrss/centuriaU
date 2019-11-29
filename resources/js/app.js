/* Trae Axios */
require("./bootstrap");

window.Vue = require("vue");
//importacion de libreria Vue Router
import VueRouter from "vue-router";
Vue.use(VueRouter);
//importando VUEX
import Vuex from "vuex";
Vue.use(Vuex);

//importamos nuestras rutas
import routes from './routes';
//importamos nuestro store de vuex
import store from './store';



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

const app = new Vue({
    el: "#app",
    //le pasamos las rutas asi
    router: new VueRouter(routes),
    //le pasamos el Store importado
    store: new Vuex.Store(store)
});
