<template>
  <main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="nav-icon fas fa-users-cog"></i> Usuarios
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
              <div class="col-md-12">
                <div class="form-group">
                  <button
                    type="button"
                    class="btn btn-success btn-lg mb-2"
                    @click="abrirModal('crear')"
                  >
                    <i class="fas fa-plus-circle"></i> Nuevo Usuario
                  </button>
                </div>
              </div>
              <div class="col-sm-12 col-lg-12">
                <div class="card card-accent-primary">
                  <div class="card-header">
                    <strong>
                      <i class="fas fa-list-ul"></i>
                      Listado de Usuarios (Total: {{objectUsers.total}})
                    </strong>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="input-group">
                            <select class="form-control" v-model="criterio">
                              <option value="name">Nombre</option>
                              <option value="email">E-Mail</option>
                            </select>
                            <!-- keydown para ejecutar cuando vayan escribiendo -->
                            <input
                              type="text"
                              placeholder="Escriba aquí"
                              v-model="buscar"
                              class="form-control"
                              @keyup.enter="getUsers(1,criterio,buscar,cantidad)"
                            />
                            <span class="input-group-append">
                              <button
                                type="button"
                                class="btn btn-primary"
                                @click="getUsers(1,criterio,buscar,cantidad)"
                              >
                                <i class="fas fa-search"></i> Buscar
                              </button>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                        <div class="form-group">
                          <div class="input-group">
                            <select
                              class="form-control"
                              v-model="cantidad"
                              v-on:change="getUsers(1,criterio,buscar,cantidad)"
                            >
                              <option value="5">5</option>
                              <option value="10">10</option>
                              <option value="20">20</option>
                              <option value="50">50</option>
                            </select>
                            <span class="input-group-append">
                              <button type="button" class="btn btn-secondary" disabled>
                                <i class="fas fa-list"></i> Listar
                              </button>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <table class="table table-responsive-md table-hover table-bordered table-sm">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nombre</th>
                          <th>Email</th>
                          <th>Estado</th>
                          <th>Rol</th>
                          <th>Sede</th>
                          <th>Creación</th>
                          <th>Acción</th>
                        </tr>
                      </thead>
                      <!-- verificamos si el objeto es vacio -->
                      <tbody v-if="objectUsers.data ==''">
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
                      <tbody v-for="(data, index) in objectUsers.data" :key="data.id">
                        <tr>
                          <td>{{++index}}</td>
                          <td v-text="data.name"></td>
                          <td v-text="data.email"></td>
                          <td v-if="data.estado_user == 1">
                            <span class="badge badge-success">Activo</span>
                          </td>
                          <td v-else>
                            <span class="badge badge-danger">Inactivo</span>
                          </td>
                          <td v-text="data.nombreRol"></td>
                          <td v-text="data.nombreSede"></td>
                          <td>{{data.created_at | moment('DD/MM/YYYY h:mm a')}}</td>
                          <td>
                            <button
                              class="btn btn-secondary"
                              @click="abrirModal('actualizar',data)"
                            >
                              <i class="far fa-edit"></i> Editar
                            </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="card-footer">
                    <!-- Implementa el vue pagination para poder cambiar pagina -->
                    <pagination
                      :data="objectUsers"
                      @pagination-change-page="getUsers"
                      align="center"
                      :limit="1"
                    ></pagination>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-lg-12">
                <div class="card card-accent-primary">
                  <div class="card-header">
                    <strong>
                      <i class="fas fa-list-ul"></i>
                      Listado de Roles
                    </strong>
                  </div>
                  <div class="card-body">
                    <table class="table table-responsive-md table-hover table-bordered table-sm">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nombre</th>
                          <th>Descripción</th>
                          <th>Fecha Creación</th>
                        </tr>
                      </thead>
                      <!-- verificamos si el objeto es vacio -->
                      <tbody v-if="!roles.length">
                        <td colspan="4">
                          <div role="alert" class="alert alert-danger text-center">
                            <div class="form-group">
                              <strong>
                                <h5>¡Sin información!</h5>
                              </strong>
                            </div>
                          </div>
                        </td>
                      </tbody>
                      <tbody v-for="(data, index) in roles" :key="data.id">
                        <tr>
                          <td>{{++index}}</td>
                          <td v-text="data.nombre"></td>
                          <td v-text="data.descripcion"></td>
                          <td>{{data.created_at | moment('DD/MM/YYYY h:mm a')}}</td>
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
    <!-- Modal modalUsuarios-->
    <section>
      <div
        class="modal"
        id="modalUsuarios"
        role="dialog"
        data-backdrop="static"
        data-keyboard="false"
      >
        <div class="modal-dialog modal-primary" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" v-if="tipoModal == 'actualizar'">
                <i class="fas fa-edit"></i> Editar Usuario
              </h4>
              <h4 class="modal-title" v-if="tipoModal == 'crear'">
                <i class="fas fa-plus-circle"></i> Nuevo Usuario
              </h4>
              <button class="close" type="button" @click="cerrarModal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" enctype="multipart/form-data">
                <div class="form-group row">
                  <label class="col-md-4 col-sm-5 col-form-label font-weight-bold">Nombre:</label>
                  <div class="col-md-8 col-sm-7">
                    <input class="form-control" type="text" v-model="nombre" />
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.nombre"
                      v-text="arrayErrors.nombre[0]"
                    ></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-sm-5 col-form-label font-weight-bold">E-Mail:</label>
                  <div class="col-md-8 col-sm-7">
                    <input class="form-control" type="text" v-model="email" />
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.email"
                      v-text="arrayErrors.email[0]"
                    ></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-sm-5 col-form-label font-weight-bold">Contraseña:</label>
                  <div class="col-md-8 col-sm-7">
                    <input class="form-control" type="password" v-model="password" />
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.password"
                      v-text="arrayErrors.password[0]"
                    ></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-sm-5 col-form-label font-weight-bold">Confirmación:</label>
                  <div class="col-md-8 col-sm-7">
                    <input
                      class="form-control"
                      type="password"
                      v-model="passwordV"
                      v-if="!password"
                      disabled
                    />
                    <input class="form-control" type="password" v-model="passwordV" v-else />
                    <span
                      class="help-block text-danger"
                      v-if="password != passwordV"
                    >Contraseñas no coinciden</span>
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.verificacion"
                      v-text="arrayErrors.verificacion[0]"
                    ></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-sm-5 col-form-label font-weight-bold">Estado:</label>
                  <div class="col-md-8 col-sm-7">
                    <v-select
                      :options="estadosUser"
                      :reduce="estado => estado.id"
                      label="estado"
                      placeholder="Seleccionar..."
                      v-model="estado"
                    >
                      <div slot="no-options">No hay Resultados!</div>
                    </v-select>
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.estado"
                      v-text="arrayErrors.estado[0]"
                    ></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-sm-5 col-form-label font-weight-bold">Rol:</label>
                  <div class="col-md-8 col-sm-7">
                    <v-select
                      :options="roles"
                      :reduce="nombre => nombre.id"
                      label="nombre"
                      placeholder="Seleccionar..."
                      v-model="rol"
                    >
                      <div slot="no-options">No hay Resultados!</div>
                    </v-select>
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.rol"
                      v-text="arrayErrors.rol[0]"
                    ></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-sm-5 col-form-label font-weight-bold">Sede:</label>
                  <div class="col-md-8 col-sm-7">
                    <v-select
                      :options="sedes"
                      :reduce="nombre => nombre.id"
                      label="nombre"
                      placeholder="Seleccionar..."
                      v-model="sede"
                    >
                      <div slot="no-options">No hay Resultados!</div>
                    </v-select>
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.sede"
                      v-text="arrayErrors.sede[0]"
                    ></span>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" @click="cerrarModal">
                <i class="far fa-times-circle"></i> Cancelar
              </button>
              <div v-if="password != passwordV"></div>
              <div v-else>
                <button class="btn btn-primary" v-if="tipoModal == 'crear'" @click="saveUser">
                  <i class="far fa-check-circle"></i> Guardar
                </button>
                <button
                  class="btn btn-primary"
                  v-if="tipoModal == 'actualizar'"
                  @click="updateUser"
                >
                  <i class="far fa-check-circle"></i> Guardar
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>
<script>
//importamos para usar el mapState, mapActions
import { mapState, mapActions } from "vuex";
export default {
  data() {
    return {
      tipoModal: "",
      arrayErrors: [],
      idUser: "",
      nombre: "",
      email: "",
      password: "",
      passwordV: "",
      estado: "",
      rol: "",
      sede: "",
      sedes: [],
      roles: [],
      estadosUser: [
        { id: "1", estado: "Activo" },
        { id: "0", estado: "Inactivo" }
      ],
      //paginacion
      objectUsers: {},
      pagActual: "1",
      cantidad: "5",
      criterio: "name",
      buscar: "",
      arrayRoles: []
    };
  },
  computed: {
    ...mapState(["infoUserAuth"])
  },
  methods: {
    ...mapActions(["getUserAuth"]),
    abrirModal(tipoModal, data) {
      let me = this;
      me.getSedes();
      switch (tipoModal) {
        case "crear": {
          me.tipoModal = "crear";
          $("#modalUsuarios").modal("show");
          break;
        }
        case "actualizar": {
          me.tipoModal = "actualizar";
          me.idUser = data["id"];
          me.nombre = data["name"];
          me.email = data["email"];
          me.password = "";
          me.passwordV = "";
          me.estado = data["estado_user"];
          me.rol = data["roles_id"];
          me.sede = data["sedes_id"];

          $("#modalUsuarios").modal("show");
          break;
        }
      }
    },
    cerrarModal() {
      let me = this;
      $("#modalUsuarios").modal("hide");
      me.nombre = "";
      me.email = "";
      me.password = "";
      me.passwordV = "";
      me.estado = "";
      me.rol = "";
      me.sede = "";
      me.arrayErrors = [];
    },
    saveUser() {
      let me = this;
      axios
        .post("/saveUser", {
          nombre: me.nombre,
          email: me.email,
          password: me.password,
          verificacion: me.passwordV,
          estado: me.estado,
          rol: me.rol,
          sede: me.sede
        })
        .then(function(response) {
          me.cerrarModal();
          Swal.fire({
            position: "top",
            type: "success",
            title: "Usuario creado con éxito",
            showConfirmButton: false,
            timer: 1500
          });
          //console.log(response);
        })
        .catch(function(error) {
          if (error.response.status == 422) {
            //preguntamos si el error es 422
            me.arrayErrors = error.response.data.errors;
          }
          //console.log(error);
        });
    },
    updateUser() {
      let me = this;
      axios
        .post("/updateUser", {
          id: me.idUser,
          nombre: me.nombre,
          email: me.email,
          password: me.password,
          verificacion: me.passwordV,
          estado: me.estado,
          rol: me.rol,
          sede: me.sede
        })
        .then(function(response) {
          me.getUsers();
          me.cerrarModal();
          Swal.fire({
            position: "top",
            type: "success",
            title: "Usuario Actualizado con éxito",
            showConfirmButton: false,
            timer: 1500
          });
          //console.log(response);
        })
        .catch(function(error) {
          if (error.response.status == 422) {
            //preguntamos si el error es 422
            me.arrayErrors = error.response.data.errors;
          }
          //console.log(error);
        });
    },
    getUsers(page, criterio, buscar, cantidad) {
      let me = this;
      //enviamos los criterios para la paginacion y igualmente el parametro buscar a la ruta, controlador pagina por la busqueda
      axios
        .get("getUsers", {
          params: {
            page: page,
            criterio: me.criterio,
            buscar: me.buscar,
            cantidad: me.cantidad
          }
        })
        .then(response => {
          me.objectUsers = response.data;
          me.pagActual = response.data.current_page; //capturamos el id de la pagina actual mostrando
        });
    },
    getSedes() {
      let me = this;
      axios
        .get("/getSedes")
        .then(function(response) {
          me.sedes = response.data;
          //console.log(response);
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
    },
    getRoles() {
      let me = this;
      axios
        .get("/getRoles")
        .then(function(response) {
          me.roles = response.data;
          //console.log(response);
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
    }
  },
  mounted() {
    this.getUserAuth();
    this.getUsers(this.pagActual, this.criterio, this.buscar, this.cantidad);
    this.getRoles();
  }
};
</script>
