<template>
  <main class="main" v-if="infoUserAuth.length">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="nav-icon icon-user-following"></i> Ingresos
      </li>
      <!-- Breadcrumb Menu-->
      <li class="breadcrumb-menu d-md-down-none">
        <div class="btn-group" role="group" aria-label="Button group">
          <router-link class="btn" to="/">
            <i class="icon-graph"></i> Escritorio
          </router-link>
          <a class="btn" href="#">
            <i class="icon-settings"></i> Configuración
          </a>
        </div>
      </li>
    </ol>
    <div class="container-fluid">
      <div class="ui-view">
        <div>
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-6 col-md-4">
                <div class="card card-accent-primary">
                  <div class="card-header">
                    <i class="icon-magnifier icons"></i>Buscar Persona
                  </div>
                  <div class="card-body">
                    <div class="input-group">
                      <input
                        class="form-control"
                        type="text"
                        placeholder="ID o Documento"
                        ref="buscarId"
                        v-model="documento"
                        @keyup.enter="buscarPersonaID"
                      />
                      <span class="input-group-append">
                        <button class="btn btn-primary" type="button" @click="buscarPersonaID">
                          <i class="fas fa-search"></i> Buscar
                        </button>
                        <button class="btn btn-primary" type="button" @click="alerta">
                          <i class="fas fa-search"></i> Alerta
                        </button>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="card card-accent-success" v-if="infoPersonaU.length">{{infoPersonaU}}</div>
                <div class="card card-accent-success" v-if="infoPersonaC.length">{{infoPersonaC}}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
<script>
//importamos para usar el mapState, mapActions
import { mapState, mapActions } from "vuex";
export default {
  data() {
    return {
      documento: "",
      infoPersonaU: [], //persona de la bd Unisangil
      infoPersonaC: [] //persona creada en mi bd
    };
  },
  computed: {
    ...mapState(["infoUserAuth"])
  },
  methods: {
    ...mapActions(["getUserAuth"]),
    buscarPersonaID() {
      let me = this;
      axios
        .get("https://apicenturia.local/api/getUsuarios", {
          params: {
            id: me.documento
          }
        })
        .then(function(response) {
          me.infoPersonaU = response.data;

          if (me.infoPersonaU == "") {
            axios
              .get("/getPersona", {
                params: {
                  id: me.documento
                }
              }) //para buscar el usuario en mi BD
              .then(function(response) {
                me.infoPersonaC = response.data;
                if (me.infoPersonaC == "") {
                  console.log("No hay datos para mostrar de mi BD");
                  console.log("No hay datos para mostrar de Unisangil");
                } else {
                  console.log("Busqueda exitosa en BD");
                  console.log("No hay datos para mostrar de Unisangil");
                }
              })
              .catch(function(error) {
                console.log(error);
              })
              .then(function() {
                // always executed
              });
          } else {
            console.log("Busqueda exitosa BD Unisangil");
          }
        })
        .catch(function(error) {
          console.log(error);
        })
        .then(function() {
          // always executed
        });
    },
    alerta() {
      Swal.fire({
        toast: true,
        position: "top-end",
        //background: "#f6e1e1",//error
        //background: "#d9ffe7", //success
        //background: "#fff1d5", //warning
        //background: "#e0f1ff", //info
        background: "#f5f8fb", //info
        type: "question",
        title: "No hay Servicio a buscar",
        showConfirmButton: false,
        timer: 2500
      });
    }
  },
  mounted() {
    //optener el Usuario autenticado
    this.getUserAuth();
    this.$refs.buscarId.focus();
  }
};
</script>
