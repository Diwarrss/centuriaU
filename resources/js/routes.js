/* //Importamos los componentes a usar
//creamos variables de los componentes
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
const Perfil = require("./components/allMenusInfo/Perfil.vue").default; */

//Importamos los componentes a usar
import Error404 from './components/Error404';
//para el Admin
import Escritorio from './components/allMenusInfo/Escritorio';
import Ingresos from './components/allMenusInfo/Ingresos';
import Personas from './components/allMenusInfo/Personas';
import Computadores from './components/allMenusInfo/Computadores';
import Reportes from './components/allMenusInfo/Reportes';
import Usuarios from './components/allMenusInfo/Usuarios';
import Universidad from './components/allMenusInfo/Universidad';
import Perfil from './components/allMenusInfo/Perfil';

export default {

    //mode: 'history',
    base: "/admin",

    routes: [{
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
    ]
};
