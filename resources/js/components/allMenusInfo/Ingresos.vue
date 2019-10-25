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
          <router-link class="btn" to="/universidad" v-if="infoUserAuth[0].roles_id == 1">
            <i class="fas fa-university"></i> Universidad
          </router-link>
        </div>
      </li>
    </ol>
    <div class="container-fluid" v-if="!infoPeriodo.length">
      <div role="alert" class="alert alert-warning text-center">
        <div class="form-group">
          <strong>
            <h3>¡No hay Periodo habilitado!</h3>
          </strong>
        </div>
      </div>
    </div>
    <div class="container-fluid" v-if="infoUserAuth.length && infoPeriodo.length">
      <div class="ui-view">
        <div>
          <div class="animated fadeIn">
            <div class="row">
              <!-- Div de buscar y mostrar informacion -->
              <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3">
                <div class="card card-accent-primary">
                  <div class="card-header">
                    <h5>
                      <strong>
                        <i class="icon-magnifier icons"></i> Buscar Persona
                      </strong>
                    </h5>
                  </div>
                  <div class="card-body">
                    <div class="input-group">
                      <input
                        class="form-control"
                        type="text"
                        placeholder="ID o Documento"
                        id="buscarId"
                        v-model="documento"
                        @keyup.enter="buscarPersona"
                      />
                      <span class="input-group-append">
                        <button class="btn btn-primary" type="button" @click="buscarPersona">
                          <i class="fas fa-search"></i> Buscar
                        </button>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-8 col-lg-8 col-xl-9">
                <div v-if="!infoPersona.length">
                  <div class="alert alert-warning text-center" role="alert">
                    <div class="form-group">
                      <h4>
                        <strong>¡Sin Información!</strong>
                      </h4>
                    </div>
                  </div>
                  <div v-if="infoUserAuth[0].roles_id == 4"></div>
                  <div v-else>
                    <crearpersona></crearpersona>
                  </div>
                </div>
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
      infoPersona: []
    };
  },
  computed: {
    ...mapState(["infoUserAuth", "infoPeriodo"])
  },
  methods: {
    ...mapActions(["getUserAuth", "getPeriodo"]),
    focus() {
      $("#buscarId").focus();
    },
    buscarPersona() {
      let me = this;
      axios
        .get("http://apicenturia.local/api/getUsuarios", {
          params: {
            id: me.documento
          }
        })
        .then(function(response) {
          me.infoPersona = response.data;
          //si no hay datos de unisangil al buscar
          if (me.infoPersona == "") {
            /* Swal.fire({
              position: "top-end",
              type: "warning",
              title: "Unisangil sin Información",
              showConfirmButton: false,
              timer: 1500
            }); */
            //realizamos busqueda en nuestra base de datos
            axios
              .get("/getPersona", {
                params: {
                  id: me.documento
                }
              })
              .then(res => {
                me.infoPersona = res.data;
                console.log(res);

                //si no hay datos en mi BD no hay ninguna persona con ese documento
                if (me.infoPersona == "") {
                  Swal.fire({
                    position: "top-end",
                    type: "error",
                    title: "Unisangil y Mi BD sin Información",
                    showConfirmButton: false,
                    timer: 1500
                  });
                }
                //si hay informacion la mostramos
                else {
                  Swal.fire({
                    position: "top-end",
                    type: "success",
                    title: "Información ok de mi BD",
                    showConfirmButton: false,
                    timer: 1500
                  });
                }
              })
              .catch(err => {
                console.error(err);
              });
          }
          //si hay datos de unisangil al buscar
          else {
            Swal.fire({
              position: "top-end",
              type: "success",
              title: "Información ok de Unisangil",
              showConfirmButton: false,
              timer: 1500
            });
          }
          console.log(response);
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  },
  mounted() {
    this.getPeriodo();
    //optener el Usuario autenticado
    this.getUserAuth();
    this.focus();
  }
};
</script>
