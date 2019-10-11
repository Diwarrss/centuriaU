<template>
  <main class="main" v-if="infoUserAuth.length">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="nav-icon fas fa-university"></i> Universidad
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
    <div class="container-fluid" v-if="infoUserAuth.length && arrayUniversidad.length">
      <div class="ui-view">
        <div>
          <div class="animated fadeIn">
            <div class="row" v-for="(data, index) in arrayUniversidad" :key="index">
              <div class="col-sm-12 col-md-6 col-lg-6 col-xl-5">
                <div class="card card-accent-info" v-if="habilitarEditar == 0">
                  <div class="card-header">
                    <h5>
                      <strong>
                        <i class="fas fa-info-circle"></i>
                        Mi Información
                      </strong>
                    </h5>
                  </div>
                  <div class="card-body">
                    <div class="form-group row">
                      <div class="col-md-3 col-xl-4">
                        <label for="universidad">Nombre:</label>
                      </div>
                      <div class="col-md-9 col-xl-8">
                        <input
                          class="form-control"
                          type="text"
                          id="universidad"
                          readonly
                          v-model="data.nombre"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-3 col-xl-4">
                        <label for="sigla">Siglas:</label>
                      </div>
                      <div class="col-md-9 col-xl-8">
                        <input
                          class="form-control"
                          id="sigla"
                          type="text"
                          v-model="data.siglas"
                          readonly
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-3 col-xl-4">
                        <label for="direccion">Dirección:</label>
                      </div>
                      <div class="col-md-9 col-xl-8">
                        <input
                          class="form-control"
                          id="direccion"
                          type="text"
                          v-model="data.direccion"
                          readonly
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-3 col-xl-4">
                        <label for="telefono">Teléfonos:</label>
                      </div>
                      <div class="col-md-9 col-xl-8">
                        <input
                          class="form-control"
                          id="telefono"
                          type="text"
                          v-model="data.telefonos"
                          readonly
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-3 col-xl-4">
                        <label for="fecha">Última Actualización:</label>
                      </div>
                      <div class="col-md-9 col-xl-8">
                        <input
                          class="form-control"
                          id="fecha"
                          type="text"
                          v-model="data.updated_at"
                          readonly
                        />
                      </div>
                    </div>
                  </div>
                  <div class="card-footer" v-if="infoUserAuth[0].roles_id == 1">
                    <button class="btn btn-success" @click="editarU">
                      <i class="fas fa-edit"></i> Editar
                    </button>
                  </div>
                </div>
                <div class="card card-accent-info" v-else>
                  <div class="card-header">
                    <h5>
                      <strong>
                        <i class="fas fa-info-circle"></i>
                        Mi Información
                      </strong>
                    </h5>
                  </div>
                  <div class="card-body">
                    <div class="form-group row">
                      <div class="col-md-3 col-xl-4">
                        <label for="universidad">Nombre:</label>
                      </div>
                      <div class="col-md-9 col-xl-8">
                        <input class="form-control" type="text" id="universidad" v-model="nombre" />
                        <span
                          class="help-block text-danger"
                          v-if="arrayErrors.nombre"
                          v-text="arrayErrors.nombre[0]"
                        ></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-3 col-xl-4">
                        <label for="sigla">Siglas:</label>
                      </div>
                      <div class="col-md-9 col-xl-8">
                        <input class="form-control" id="sigla" type="text" v-model="siglas" />
                        <span
                          class="help-block text-danger"
                          v-if="arrayErrors.siglas"
                          v-text="arrayErrors.siglas[0]"
                        ></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-3 col-xl-4">
                        <label for="direccion">Dirección:</label>
                      </div>
                      <div class="col-md-9 col-xl-8">
                        <input class="form-control" id="direccion" type="text" v-model="direccion" />
                        <span
                          class="help-block text-danger"
                          v-if="arrayErrors.direccion"
                          v-text="arrayErrors.direccion[0]"
                        ></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-3 col-xl-4">
                        <label for="telefono">Teléfonos:</label>
                      </div>
                      <div class="col-md-9 col-xl-8">
                        <input class="form-control" id="telefono" type="text" v-model="telefonos" />
                        <span
                          class="help-block text-danger"
                          v-if="arrayErrors.telefonos"
                          v-text="arrayErrors.telefonos[0]"
                        ></span>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <button class="btn btn-success" @click="actualizarU">
                      <i class="fas fa-upload"></i> Actualizar
                    </button>
                    <button class="btn btn-danger" @click="cancelarUpdate">
                      <i class="fas fa-close"></i> Cancelar
                    </button>
                  </div>
                </div>
                <div class="card card-accent-info">
                  <div class="card-header">
                    <h5>
                      <strong>
                        <i class="far fa-images"></i>
                        Mi Logotipo
                      </strong>
                    </h5>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <img
                        :src="data.url_imagen"
                        class="rounded mx-auto d-block img-fluid"
                        width="100"
                      />
                    </div>
                    <div class="form-group" v-if="infoUserAuth[0].roles_id == 1">
                      <div class="custom-file">
                        <input
                          type="file"
                          class="custom-file-input"
                          name="imagen"
                          id="imagen"
                          @change="obtenerImagen"
                        />
                        <label
                          class="custom-file-label"
                          for="file"
                          v-if="!imagenEnviar"
                        >Elegir Imagen</label>
                        <label class="custom-file-label" for="file" v-else>{{imagenEnviar.name}}</label>

                        <span
                          class="help-block text-danger"
                          v-if="arrayErrors.imagen"
                          v-text="arrayErrors.imagen[0]"
                        ></span>
                      </div>
                    </div>
                    <img class="rounded mx-auto d-block img-fluid" width="100" :src="cambioImagen" />
                    <div class="form-group align-content-center" v-if="imagenEnviar">
                      <button class="btn btn-success" @click="enviarImagen(data)">
                        <i class="fas fa-upload"></i> Actualizar
                      </button>
                    </div>
                    <div v-else></div>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6 col-xl-7">
                <div class="card card-accent-info">
                  <div class="card-header">
                    <h5>
                      <strong>
                        <i class="far fa-clock"></i> Periodos
                        <button
                          v-if="infoUserAuth[0].roles_id == 1"
                          class="btn btn-primary ml-2"
                          @click="abrirModal('crear')"
                        >
                          <i class="fas fa-plus-circle"></i> Nuevo
                        </button>
                      </strong>
                    </h5>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group">
                          <div class="input-group">
                            <select class="form-control" v-model="criterio">
                              <option value="nombre">Nombre</option>
                              <option value="created_at">Creación</option>
                            </select>
                            <!-- keydown para ejecutar cuando vayan escribiendo -->
                            <input
                              type="text"
                              placeholder="Escriba aquí"
                              v-model="buscar"
                              class="form-control"
                              @keyup.enter="getPeriodosAll(1,criterio,buscar,cantidad)"
                            />
                            <span class="input-group-append">
                              <button
                                type="button"
                                class="btn btn-primary"
                                @click="getPeriodosAll(1,criterio,buscar,cantidad)"
                              >
                                <i class="fas fa-search"></i> Buscar
                              </button>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                        <div class="form-group">
                          <div class="input-group">
                            <select
                              class="form-control"
                              v-model="cantidad"
                              v-on:change="getPeriodosAll(1,criterio,buscar,cantidad)"
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
                          <th>Descripción</th>
                          <th>Estado</th>
                          <th>Creación</th>
                          <th>Acción</th>
                        </tr>
                      </thead>
                      <!-- verificamos si el objeto es vacio -->
                      <tbody v-if="objectPeriodos.data ==''">
                        <td colspan="6">
                          <div role="alert" class="alert alert-danger text-center">
                            <div class="form-group">
                              <strong>
                                <h5>¡Sin información!</h5>
                              </strong>
                            </div>
                          </div>
                        </td>
                      </tbody>
                      <tbody v-for="(data, index) in objectPeriodos.data" :key="data.id">
                        <tr>
                          <!-- para mostrar numericamente -->
                          <td>{{++index}}</td>
                          <td v-text="data.nombre"></td>
                          <td v-text="data.descripcion"></td>
                          <td v-if="data.estado_periodo == '1'">
                            <span class="badge badge-success">Activo</span>
                          </td>
                          <td v-else-if="data.estado_periodo == '0'">
                            <span class="badge badge-danger">Inactivo</span>
                          </td>
                          <td>{{data.created_at | moment('DD/MM/YYYY h:mm a')}}</td>
                          <td>
                            <button
                              v-if="infoUserAuth[0].roles_id == 1"
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
                      :data="objectPeriodos"
                      @pagination-change-page="getPeriodosAll"
                      align="center"
                      :limit="1"
                    ></pagination>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal modalPeriodo-->
    <section>
      <div
        class="modal"
        id="modalPeriodo"
        role="dialog"
        aria-labelledby="myModalLabel2"
        data-backdrop="static"
        data-keyboard="false"
      >
        <div class="modal-dialog modal-primary" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" v-if="tipoModal == 'actualizar'">
                <i class="fas fa-edit"></i> Editar Periodo
              </h4>
              <h4 class="modal-title" v-if="tipoModal == 'crear'">
                <i class="fas fa-plus-circle"></i> Nuevo Periodo
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
                    <input class="form-control" type="text" v-model="nombre_periodo" />
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.nombre"
                      v-text="arrayErrors.nombre[0]"
                    ></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-sm-5 col-form-label font-weight-bold">Descripción:</label>
                  <div class="col-md-8 col-sm-7">
                    <input class="form-control" type="text" v-model="descripcion" />
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.descripcion"
                      v-text="arrayErrors.descripcion[0]"
                    ></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-sm-5 col-form-label font-weight-bold">Estado:</label>
                  <div class="col-md-8 col-sm-7">
                    <v-select
                      :options="estadosPeriodo"
                      :reduce="estado => estado.id"
                      label="estado"
                      placeholder="Seleccionar..."
                      v-model="estado"
                    >
                      <div slot="no-options">No hay Resultados!</div>
                    </v-select>
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.estado_periodo"
                      v-text="arrayErrors.estado_periodo[0]"
                    ></span>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" @click="cerrarModal">
                <i class="far fa-times-circle"></i> Cancelar
              </button>
              <button class="btn btn-primary" v-if="tipoModal == 'crear'" @click="savePeriodo">
                <i class="far fa-check-circle"></i> Guardar
              </button>
              <button
                class="btn btn-primary"
                v-if="tipoModal == 'actualizar'"
                @click="updatePeriodo"
              >
                <i class="far fa-check-circle"></i> Guardar
              </button>
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
      arrayErrors: [],
      arrayUniversidad: [],
      imagenAnterior: "",
      imagenMiniatura: "",
      imagenEnviar: "",
      habilitarEditar: 0,
      idU: "",
      nombre: "",
      siglas: "",
      direccion: "",
      telefonos: "",
      objectPeriodos: {},
      criterio: "nombre",
      buscar: "",
      cantidad: "5",
      pagActual: "",
      tipoModal: "",
      nombre_periodo: "",
      descripcion: "",
      estadosPeriodo: [
        { id: "1", estado: "Activo" },
        { id: "0", estado: "Inactivo" }
      ],
      estado: "",
      periodoId: ""
    };
  },
  computed: {
    ...mapState(["infoUserAuth"]),
    cambioImagen() {
      return this.imagenMiniatura;
    }
  },
  methods: {
    ...mapActions(["getUserAuth"]),
    getUniversidad() {
      let me = this;
      axios
        .get("/getUniversidad")
        .then(function(response) {
          me.arrayUniversidad = response.data;
          me.imagenAnterior = response.data[0].url_imagen;
          me.idU = response.data[0].id;
          //console.log(response);
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
    },
    obtenerImagen(e) {
      let me = this;
      let file = event.target.files[0];

      me.imagenEnviar = file; //guardamos el archivo en esta variable
      me.cargarImagen(file);
      //console.log(me.imagenEnviar);
    },
    cargarImagen(file) {
      let me = this;
      let reader = new FileReader(); //manejar archivos
      //la e hace referencia a file
      reader.onload = e => {
        me.imagenMiniatura = e.target.result;
      };
      reader.readAsDataURL(file); //url de imagen cargada
    },
    enviarImagen(data) {
      let me = this;
      let formData = new FormData();
      formData.append("idUniversidad", data["id"]);
      formData.append("imagenAnterior", me.imagenAnterior);
      formData.append("imagen", me.imagenEnviar);

      //le enviamos formdata q lleva toda la data
      axios
        .post("/updateImagen", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        }) //le envio el parametro completo
        .then(function(response) {
          me.imagenMiniatura = "";
          me.imagenEnviar = "";

          me.getUniversidad();
          //si es exitoso mostramos el resultado enviado desde el server
          Swal.fire({
            position: "top",
            type: "success",
            title: "Logotipo Actualizado con éxito",
            showConfirmButton: false,
            timer: 1500
          });
          //console.log(response.data);
        })
        .catch(function(error) {
          if (error.response.status == 422) {
            //preguntamos si el error es 422
            me.arrayErrors = error.response.data.errors; //guardamos la respuesta del server de errores en el array arrayErrors
          }
        });
    },
    editarU() {
      let me = this;
      me.habilitarEditar = 1;
      me.nombre = me.arrayUniversidad[0].nombre;
      me.siglas = me.arrayUniversidad[0].siglas;
      me.direccion = me.arrayUniversidad[0].direccion;
      me.telefonos = me.arrayUniversidad[0].telefonos;
    },
    actualizarU() {
      let me = this;
      axios
        .post("/updateUniversidad", {
          id: me.idU,
          nombre: me.nombre,
          siglas: me.siglas,
          direccion: me.direccion,
          telefonos: me.telefonos
        }) //le envio el parametro completo
        .then(function(response) {
          me.arrayErrors = [];
          me.getUniversidad();
          me.habilitarEditar = 0;
          //si es exitoso mostramos el resultado enviado desde el server
          Swal.fire({
            position: "top",
            type: "success",
            title: "Información actualizada con éxito",
            showConfirmButton: false,
            timer: 1500
          });
          //console.log(response.data);
        })
        .catch(function(error) {
          if (error.response.status == 422) {
            //preguntamos si el error es 422
            me.arrayErrors = error.response.data.errors; //guardamos la respuesta del server de errores en el array arrayErrors
          }
        });
    },
    cancelarUpdate() {
      let me = this;
      me.getUniversidad();
      me.habilitarEditar = 0;
      me.arrayErrors = [];
    },
    getPeriodosAll(page, criterio, buscar, cantidad) {
      let me = this;

      axios
        .get("/getPeriodosAll", {
          params: {
            page: page,
            criterio: me.criterio,
            buscar: me.buscar,
            cantidad: me.cantidad
          }
        })
        .then(function(response) {
          me.objectPeriodos = response.data;
          me.pagActual = response.data.current_page;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    cerrarModal() {
      let me = this;
      me.nombre_periodo = "";
      me.descripcion = "";
      me.estado = "";
      me.arrayErrors = [];
      $("#modalPeriodo").modal("hide");
    },
    abrirModal(tipoModal, data) {
      let me = this;
      switch (tipoModal) {
        case "crear": {
          me.tipoModal = "crear";
          $("#modalPeriodo").modal("show");
          break;
        }
        case "actualizar": {
          me.periodoId = data["id"];
          me.nombre_periodo = data["nombre"];
          me.descripcion = data["descripcion"];
          me.estado = data["estado_periodo"];

          me.tipoModal = "actualizar";
          $("#modalPeriodo").modal("show");
          break;
        }
      }
    },
    savePeriodo() {
      let me = this;

      axios
        .post("/savePeriodo", {
          nombre: me.nombre_periodo,
          descripcion: me.descripcion,
          estado_periodo: me.estado
        })
        .then(function(response) {
          me.getPeriodosAll(me.pagActual, me.criterio, me.buscar, me.cantidad);
          me.cerrarModal();
          Swal.fire({
            position: "top",
            type: "success",
            title: "Periodo creado con éxito",
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
    updatePeriodo() {
      let me = this;
      axios
        .put("/updatePeriodo", {
          id: me.periodoId,
          nombre: me.nombre_periodo,
          descripcion: me.descripcion,
          estado_periodo: me.estado
        })
        .then(function(response) {
          me.getPeriodosAll(me.pagActual, me.criterio, me.buscar, me.cantidad);
          me.cerrarModal();
          Swal.fire({
            position: "top",
            type: "success",
            title: "Periodo actualizado con éxito",
            showConfirmButton: false,
            timer: 1500
          });
        })
        .catch(function(error) {
          if (error.response.status == 422) {
            //preguntamos si el error es 422
            me.arrayErrors = error.response.data.errors;
          }
          console.log(error);
        });
    }
  },
  mounted() {
    this.getUserAuth();
    this.getUniversidad();
    this.getPeriodosAll(
      this.pagActual,
      this.criterio,
      this.buscar,
      this.cantidad
    );
  }
};
</script>
