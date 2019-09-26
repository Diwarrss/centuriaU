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
                      <i class="fas fa-list-ul"></i>
                      Listado de Personas (Total: {{objectPersonas.total}})
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
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="input-group">
                          <select class="form-control col-md-5" v-model="criterio">
                            <option value="numero_documento">Número Documento</option>
                            <option value="programa">Programa</option>
                            <option value="sede">Sede</option>
                          </select>
                          <input
                            type="text"
                            placeholder="Texto..."
                            v-model="buscar"
                            class="form-control"
                            @keyup.enter="getPersonas(1,buscar,criterio)"
                          />
                          <span class="input-group-append">
                            <button
                              type="button"
                              class="btn btn-primary"
                              @click="getPersonas(1,buscar,criterio)"
                            >
                              <i class="fas fa-search"></i> Buscar
                            </button>
                          </span>
                        </div>
                      </div>
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
                      <!-- verificamos si el objeto es vacio -->
                      <tbody v-if="objectPersonas.data ==''">
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
                      <tbody v-for="data in objectPersonas.data" :key="data.id">
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
                  <div class="card-footer">
                    <!-- Implementa el vue pagination -->
                    <pagination
                      :data="objectPersonas"
                      @pagination-change-page="getPersonas"
                      align="center"
                    ></pagination>
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
      objectPersonas: {},
      cant: 5,
      criterio: "numero_documento",
      buscar: ""
    };
  },
  computed: {
    ...mapState(["infoUserAuth"])
  },
  methods: {
    ...mapActions(["getUserAuth"]),
    //metodo para obtener las personas y el array completo
    getPersonas(page = 1) {
      let me = this;
      axios.get("getPersonas?page=" + page).then(response => {
        this.objectPersonas = response.data;
      });
    },
    /* getPersonas() {
      let me = this;
      axios
        .get("/getPersonas")
        .then(function(response) {
          // handle success
          me.objectPersonas = response.data;
          //console.log(response);
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
    }, */
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
