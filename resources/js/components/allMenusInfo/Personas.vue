<template>
  <main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="nav-icon icon-people"></i> Personas
      </li>
      <!-- Breadcrumb Menu-->
      <li class="breadcrumb-menu d-md-down-none">
        <div class="btn-group" role="group" aria-label="Button group">
          <router-link class="btn" to="/">
            <i class="icon-graph"></i> Escritorio
          </router-link>
          <router-link class="btn" to="/universidad">
            <i class="fas fa-university"></i> Universidad
          </router-link>
        </div>
      </li>
    </ol>
    <div class="container-fluid" v-if="infoUserAuth.length">
      <div class="ui-view">
        <div>
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12 col-lg-12"></div>
              <div class="col-sm-12 col-lg-12">
                <div class="card card-accent-primary">
                  <div class="card-header">
                    <strong>
                      <i class="fas fa-list-ul"></i> Listado de Personas
                    </strong>
                    <div class="card-header-actions">
                      <button class="btn btn-success mb-2">
                        <i class="far fa-file-excel"></i> Descargar Datos
                      </button>
                      <button class="btn btn-primary mb-2">
                        <i class="fas fa-file-import"></i> Cargar Datos
                      </button>
                      <button class="btn btn-secondary mb-2">
                        <i class="fas fa-file-download"></i> Formato
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div>
                      <select class="form-control">
                        <option value="Activo" selected>Nombres</option>
                        <option value="Inactivo">Apellidos</option>
                        <option value="Inactivo">Programa</option>
                      </select>
                      <input type="text" class="form-control" placeholder="Buscar..." />
                    </div>
                    <table class="table table-responsive-md table-hover table-md">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Documento</th>
                          <th>Nombres y Apellidos</th>
                          <th>Estado</th>
                          <th>Tipo</th>
                          <th>Programa</th>
                          <th>Sede</th>
                          <th>Acción</th>
                        </tr>
                      </thead>
                      <tbody v-if="!arrayPersonas.length">
                        <td colspan="8">
                          <div role="alert" class="alert alert-danger text-center">
                            <div class="form-group">
                              <strong>
                                <h5>¡Sin información!</h5>
                              </strong>
                            </div>
                          </div>
                        </td>
                      </tbody>
                      <tbody v-for="data in arrayPersonas" :key="data.id">
                        <tr>
                          <td v-text="data.id"></td>
                          <td>{{data.tipo_documento}} {{data.numero_documento}}</td>
                          <td>{{data.nombre1}} {{data.nombre2}} {{data.apellido1}} {{data.apellido2}}</td>
                          <td v-text="data.estado_persona"></td>
                          <td v-text="data.tipo_persona"></td>
                          <td v-text="data.programa"></td>
                          <td v-text="data.sede"></td>
                          <td>
                            <button class="btn btn-success" @click="editarUsuario(data.id)">Editar</button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
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
      arrayPersonas: []
    };
  },
  computed: {
    ...mapState(["infoUserAuth"])
  },
  methods: {
    ...mapActions(["getUserAuth"]),
    getPersonas() {
      let me = this;
      axios
        .get("/getPersonas")
        .then(function(response) {
          // handle success
          me.arrayPersonas = response.data;
          //console.log(response);
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
    },
    editarUsuario(id) {
      Swal.fire({
        toast: true,
        position: "top-end",
        background: "#f6e1e1", //error
        //background: "#d9ffe7", //success
        //background: "#fff1d5", //warning
        //background: "#e0f1ff", //info
        //background: "#f5f8fb", //question
        type: "error",
        title: "Usuario Elegido",
        showConfirmButton: false,
        timer: 2500
      });
    }
  },
  mounted() {
    this.getUserAuth();
    this.getPersonas();
  }
};
</script>
