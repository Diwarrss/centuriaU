<template>
  <main class="main" v-if="infoUserAuth.length">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="nav-icon icon-screen-desktop"></i> Computadores
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
    <div class="container-fluid" v-if="infoUserAuth.length">
      <div class="ui-view">
        <div>
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-md-12">
                <div v-if="infoUserAuth[0].roles_id == 4"></div>
                <div class="form-group" v-else>
                  <button
                    type="button"
                    class="btn btn-success btn-lg mb-2"
                    @click="abrirModal('crear')"
                  >
                    <i class="fas fa-plus-circle"></i> Nuevo Computador
                  </button>
                  <router-link to="/ingresos" class="btn btn-primary btn-lg mb-2">
                    <i class="fas fa-plus-circle"></i> Nuevo Préstamo
                  </router-link>
                </div>
              </div>
              <div class="col-sm-12 col-lg-12">
                <div class="card card-accent-primary">
                  <div class="card-header">
                    <h5>
                      <strong>
                        <i class="fas fa-laptop"></i>
                        Listado de Computadores (Total: {{objectCompu.total}})
                      </strong>
                    </h5>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <div class="input-group">
                            <select class="form-control" v-model="criterio">
                              <option value="nombre">Nombre</option>
                            </select>
                            <!-- keydown para ejecutar cuando vayan escribiendo -->
                            <input
                              type="text"
                              placeholder="Escriba aquí"
                              v-model="buscar"
                              class="form-control"
                              @keyup.enter="getCompu(1,criterio,buscar,cantidad)"
                            />
                            <span class="input-group-append">
                              <button
                                type="button"
                                class="btn btn-primary"
                                @click="getCompu(1,criterio,buscar,cantidad)"
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
                              v-on:change="getCompu(1,criterio,buscar,cantidad)"
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
                    <table class="table table-responsive-lg table-hover table-bordered table-sm">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Computador</th>
                          <th>Descripción</th>
                          <th>Estado</th>
                          <th>Sede</th>
                          <th>Creación</th>
                          <th>Observación</th>
                          <th>Acción</th>
                        </tr>
                      </thead>
                      <!-- verificamos si el objeto es vacio -->
                      <tbody v-if="objectCompu.data ==''">
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
                      <tbody v-for="(data, index) in objectCompu.data" :key="data.compuId">
                        <tr>
                          <!-- para mostrar numericamente -->
                          <td>{{++index}}</td>
                          <td v-text="data.nombreCompu"></td>
                          <td v-text="data.descripcion"></td>
                          <td v-if="data.estado_computador == '2'">
                            <span class="badge badge-warning">Ocupado</span>
                          </td>
                          <td v-else-if="data.estado_computador == '1'">
                            <span class="badge badge-success">Disponible</span>
                          </td>
                          <td v-else>
                            <span class="badge badge-danger">Inactivo</span>
                          </td>
                          <td v-text="data.nombreSede"></td>
                          <td>{{data.created_at | moment('DD/MM/YYYY h:mm a')}}</td>
                          <td v-text="data.observacion"></td>
                          <td v-if="infoUserAuth[0].roles_id == 4"></td>
                          <td v-else>
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
                      :data="objectCompu"
                      @pagination-change-page="getCompu"
                      align="center"
                      :limit="1"
                    ></pagination>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-lg-12">
                <div class="card card-accent-success">
                  <div class="card-header">
                    <h5>
                      <strong>
                        <i class="fas fa-laptop"></i>
                        Listado de Préstamos (Total: {{objectPrestamos.total}})
                      </strong>
                    </h5>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <div class="input-group">
                            <select class="form-control" v-model="criterioP">
                              <option value="nombre1">Nombre Persona</option>
                              <option value="numero_documento">ID o Documento</option>
                            </select>
                            <!-- keydown para ejecutar cuando vayan escribiendo -->
                            <input
                              type="text"
                              placeholder="Escriba aquí"
                              v-model="buscarP"
                              class="form-control"
                              @keyup.enter="getPrestamos(1,criterioP,buscarP,cantidadP)"
                            />
                            <span class="input-group-append">
                              <button
                                type="button"
                                class="btn btn-primary"
                                @click="getPrestamos(1,criterioP,buscarP,cantidadP)"
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
                              v-model="cantidadP"
                              v-on:change="getPrestamos(1,criterioP,buscarP,cantidadP)"
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
                    <table class="table table-responsive-lg table-hover table-bordered table-sm">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Computador</th>
                          <th>Observación</th>
                          <th>Documento</th>
                          <th>Persona</th>
                          <th>Sede</th>
                          <th>Fecha Inicio</th>
                          <th>Fecha Fin</th>
                          <th>Estado</th>
                          <th>Acción</th>
                        </tr>
                      </thead>
                      <!-- verificamos si el objeto es vacio -->
                      <tbody v-if="objectPrestamos.data ==''">
                        <td colspan="10">
                          <div role="alert" class="alert alert-danger text-center">
                            <div class="form-group">
                              <strong>
                                <h5>¡Sin información!</h5>
                              </strong>
                            </div>
                          </div>
                        </td>
                      </tbody>
                      <tbody v-for="(data, index) in objectPrestamos.data" :key="data.ingresosID">
                        <tr>
                          <!-- para mostrar numericamente -->
                          <td>{{++index}}</td>
                          <td v-text="data.nombrePC"></td>
                          <td v-text="data.observacion"></td>
                          <td>{{data.tipo_documento}} {{data.numero_documento}}</td>
                          <td>{{data.nombre1}} {{data.nombre2}} {{data.apellido1}} {{data.apellido2}}</td>
                          <td v-text="data.nombreSede"></td>
                          <td>{{data.fechaPrestamo | moment('DD/MM/YYYY h:mm a')}}</td>
                          <td v-if="data.fechaPrestamo == data.fechaFin"></td>
                          <td v-else>{{data.fechaFin | moment('DD/MM/YYYY h:mm a')}}</td>
                          <td v-if="data.estado_prestamo == '1'">
                            <span class="badge badge-warning">Activo</span>
                          </td>
                          <td v-else-if="data.estado_prestamo == '0'">
                            <span class="badge badge-success">Finalizado</span>
                          </td>
                          <td>
                            <div
                              v-if="infoUserAuth[0].sedes_id == null || infoUserAuth[0].roles_id == 4"
                            ></div>
                            <div v-else-if="data.estado_prestamo == 1">
                              <button
                                class="btn btn-secondary"
                                @click="recibirEquipo(data.computadorID, data.prestamoID)"
                              >
                                <i class="far fa-check-circle"></i> Recibido
                              </button>
                            </div>
                            <div v-else-if="data.estado_prestamo == 0">
                              <button class="btn btn-success" disabled>
                                <i class="far fa-check-circle"></i> Ya Recibido
                              </button>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="card-footer">
                    <!-- Implementa el vue pagination para poder cambiar pagina -->
                    <pagination
                      :data="objectPrestamos"
                      @pagination-change-page="getPrestamos"
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
      <!-- Modal modalComputador-->
      <section>
        <div
          class="modal"
          id="modalComputador"
          role="dialog"
          aria-labelledby="myModalLabel2"
          data-backdrop="static"
          data-keyboard="false"
        >
          <div class="modal-dialog modal-primary" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" v-if="tipoModal == 'actualizar'">
                  <i class="fas fa-edit"></i> Editar Computador
                </h4>
                <h4 class="modal-title" v-if="tipoModal == 'crear'">
                  <i class="fas fa-plus-circle"></i> Nuevo Computador
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
                    <label class="col-md-4 col-sm-5 col-form-label font-weight-bold">Observación:</label>
                    <div class="col-md-8 col-sm-7">
                      <textarea class="form-control" type="text" v-model="observacion"></textarea>
                      <span
                        class="help-block text-danger"
                        v-if="arrayErrors.observacion"
                        v-text="arrayErrors.observacion[0]"
                      ></span>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-4 col-sm-5 col-form-label font-weight-bold">Estado:</label>
                    <div class="col-md-8 col-sm-7">
                      <v-select
                        :options="estadosCompu"
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
                <button class="btn btn-primary" v-if="tipoModal == 'crear'" @click="saveCompu">
                  <i class="far fa-check-circle"></i> Guardar
                </button>
                <button
                  class="btn btn-primary"
                  v-if="tipoModal == 'actualizar'"
                  @click="updateCompu()"
                >
                  <i class="far fa-check-circle"></i> Guardar
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Modal modal Reporte daño Computador-->
      <section>
        <div
          class="modal"
          id="modalObservacion"
          role="dialog"
          aria-labelledby="myModalLabel2"
          data-backdrop="static"
          data-keyboard="false"
        >
          <div class="modal-dialog modal-dialog-centered modal-warning" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">
                  <i class="fas fa-exclamation-triangle"></i> Observación Préstamo
                </h4>
                <button class="close" type="button" @click="cerrarObservacion" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" enctype="multipart/form-data">
                  <div class="form-group row">
                    <label class="col-md-4 col-sm-5 col-form-label font-weight-bold">Observación:</label>
                    <div class="col-md-8 col-sm-7">
                      <textarea class="form-control" type="text" v-model="observacion"></textarea>
                      <span
                        class="help-block text-danger"
                        v-if="arrayErrors.observacion"
                        v-text="arrayErrors.observacion[0]"
                      ></span>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" type="button" @click="cerrarObservacion">
                  <i class="far fa-times-circle"></i> Cancelar
                </button>
                <button class="btn btn-primary" @click="reportarObservacion">
                  <i class="far fa-check-circle"></i> Guardar
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>
</template>
<script>
//importamos para usar el mapState, mapActions
import { mapState, mapActions } from "vuex";
export default {
  data() {
    return {
      objectCompu: {},
      objectPrestamos: {},
      estadosCompu: [
        { id: "1", estado: "Disponible" },
        { id: "2", estado: "Ocupado" },
        { id: "0", estado: "Inactivo" }
      ],
      pagActual: "",
      pagActualP: "",
      buscar: "",
      buscarP: "",
      cantidad: "5",
      cantidadP: "5",
      criterio: "nombre",
      criterioP: "nombre1",
      arrayErrors: [],
      sedes: [],
      nombre: "",
      descripcion: "",
      estado: "1",
      sede: "",
      compuId: "",
      tipoModal: "",
      observacion: "",
      prestamoID: ""
    };
  },
  computed: {
    ...mapState(["infoUserAuth"])
  },
  methods: {
    ...mapActions(["getUserAuth"]),
    getCompu(page, criterio, buscar, cantidad) {
      let me = this;
      //enviamos los criterios para la paginacion y igualmente el parametro buscar a la ruta, controlador pagina por la busqueda
      axios
        .get("getCompu", {
          params: {
            page: page,
            criterio: me.criterio,
            buscar: me.buscar,
            cantidad: me.cantidad
          }
        })
        .then(response => {
          me.objectCompu = response.data;
          me.pagActual = response.data.current_page; //capturamos el id de la pagina actual mostrando
        });
    },
    getPrestamos(page, criterioP, buscarP, cantidadP) {
      let me = this;
      //enviamos los criterios para la paginacion y igualmente el parametro buscar a la ruta, controlador pagina por la busqueda
      axios
        .get("getPrestamos", {
          params: {
            page: page,
            criterio: me.criterioP,
            buscar: me.buscarP,
            cantidad: me.cantidadP
          }
        })
        .then(response => {
          me.objectPrestamos = response.data;
          me.pagActualP = response.data.current_page; //capturamos el id de la pagina actual mostrando
        });
    },
    saveCompu() {
      let me = this;
      axios
        .post("/saveCompu", {
          nombre: me.nombre,
          descripcion: me.descripcion,
          observacion: me.observacion,
          estado: me.estado,
          sede: me.sede
        })
        .then(function(response) {
          me.getCompu(me.pagActual, me.criterio, me.buscar, me.cantidad);
          me.cerrarModal();
          Swal.fire({
            position: "top",
            type: "success",
            title: "Computador creado con éxito",
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
    updateCompu() {
      let me = this;
      axios
        .put("/updateCompu", {
          //ruta para actualizar los datos de web.php
          nombre: me.nombre,
          descripcion: me.descripcion,
          observacion: me.observacion,
          estado: me.estado,
          sede: me.sede,
          compuId: me.compuId
        })
        .then(function(response) {
          me.getCompu(me.pagActual, me.criterio, me.buscar, me.cantidad);
          me.getPrestamos(
            me.pagActualP,
            me.criterioP,
            me.buscarP,
            me.cantidadP
          );
          me.cerrarModal();
          Swal.fire({
            position: "top",
            type: "success",
            title: "Computador actualizado con éxito",
            showConfirmButton: false,
            timer: 1500
          });
        })
        .catch(function(error) {
          if (error.response.status == 422) {
            //preguntamos si el error es 422
            me.arrayErrors = error.response.data.errors;
          }
          //console.log(error);
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
          //console.log(error);
        });
    },
    abrirModal(tipoModal, data) {
      let me = this;
      switch (tipoModal) {
        case "crear": {
          me.getSedes();
          me.nombre = "";
          me.descripcion = "";
          me.descripcion = "";
          me.estado = "";
          me.sede = "";
          me.tipoModal = "crear";
          $("#modalComputador").modal("show");
          break;
        }
        case "actualizar": {
          me.getSedes(), (me.compuId = data["compuId"]);
          me.nombre = data["nombreCompu"];
          me.descripcion = data["descripcion"];
          me.observacion = data["observacion"];
          me.estado = data["estado_computador"];
          me.sede = data["sedes_id"];
          me.tipoModal = "actualizar";
          $("#modalComputador").modal("show");
          break;
        }
      }
    },
    cerrarModal() {
      let me = this;
      $("#modalComputador").modal("hide");
      (me.arrayErrors = []),
        (me.nombre = ""),
        (me.descripcion = ""),
        (me.estado = "1"),
        (me.sede = "");
    },
    recibirEquipo(computadorID, prestamoID) {
      let me = this;
      me.prestamoID = prestamoID;
      const swalPrincipal = Swal.mixin({
        customClass: {
          confirmButton: "btn btn-success m-1",
          cancelButton: "btn btn-danger m-1"
        },
        buttonsStyling: false
      });

      swalPrincipal
        .fire({
          title: "¿Computador recibido en buen estado?",
          type: "question",
          showCancelButton: true,
          confirmButtonText: '<i class="fas fa-check"></i> Si',
          cancelButtonText: '<i class="fas fa-times"></i> No'
        })
        .then(result => {
          if (result.value) {
            axios
              .post("/finalizarPrestamo", {
                computadorID: computadorID,
                prestamoID: prestamoID
              })
              .then(function(response) {
                me.getPrestamos(
                  me.pagActualP,
                  me.criterioP,
                  me.buscarP,
                  me.cantidadP
                );
                me.getCompu(me.pagActual, me.criterio, me.buscar, me.cantidad);
                swalPrincipal.fire({
                  toast: true,
                  position: "top",
                  type: "success",
                  title: "Equipo disponible!",
                  showConfirmButton: false,
                  timer: 1500
                });
              })
              .catch(function(error) {
                if (error.response.status == 422) {
                  //preguntamos si el error es 422
                  swalPrincipal.fire({
                    toast: true,
                    position: "top",
                    type: "error",
                    title: "Se produjo un Error, Reintentar",
                    showConfirmButton: false,
                    timer: 2500
                  });
                }
                //console.log(error.response.data.errors);
              });
          } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
          ) {
            me.abrirModalReporte();
          }
        });
    },
    abrirModalReporte() {
      $("#modalObservacion").modal("show");
    },
    cerrarObservacion() {
      let me = this;
      $("#modalObservacion").modal("hide");
      me.observacion = "";
    },
    reportarObservacion() {
      let me = this;
      axios
        .post("/reportarObservacion", {
          //ruta para actualizar los datos de web.php
          prestamoID: me.prestamoID,
          observacion: me.observacion
        })
        .then(function(response) {
          me.getCompu(me.pagActual, me.criterio, me.buscar, me.cantidad);
          me.getPrestamos(
            me.pagActualP,
            me.criterioP,
            me.buscarP,
            me.cantidadP
          );
          me.cerrarObservacion();
          Swal.fire({
            position: "top",
            type: "success",
            title: "Observación registrada con éxito, Computador no disponible",
            showConfirmButton: false,
            timer: 1500
          });
        })
        .catch(function(error) {
          if (error.response.status == 422) {
            //preguntamos si el error es 422
            me.arrayErrors = error.response.data.errors;
          }
          //console.log(error);
        });
    }
  },
  mounted() {
    this.getUserAuth();
    this.getCompu(this.pagActual, this.criterio, this.buscar, this.cantidad);
    this.getPrestamos(
      this.pagActualP,
      this.criterioP,
      this.buscarP,
      this.cantidadP
    );
  }
};
</script>
