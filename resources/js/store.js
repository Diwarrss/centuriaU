window.axios = require('axios');
export default {
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
        //mediante axios
        getUserAuth: async function ({
            commit
        }) {
            const data = await axios.get('/getUserAuth')
            const dataUser = data.data
            commit('llenarInfo', dataUser)
        },

        getPeriodo: async function ({
            commit
        }) {
            const data = await axios.get('/getPeriodo')
            const dataPeriodo = data.data
            commit('llenarPeriodo', dataPeriodo)
        }

        /* METODO FETCH
        getUserAuth: async function ({commit}) {
            const data = await fetch("/getUserAuth");
            const dataUser = await data.json(); //no es necesario pasarlo a json laravel ya lo envia en este formato
            commit("llenarInfo", dataUser);
        },
        getPeriodo: async function ({commit}) {
            const datos = await fetch("/getPeriodo");
            const dataPeriodo = await datos.json(); //no es necesario pasarlo a json laravel ya lo envia en este formato

            commit("llenarPeriodo", dataPeriodo);
        } */
    }
};
