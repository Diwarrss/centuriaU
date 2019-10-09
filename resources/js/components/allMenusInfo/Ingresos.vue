<template>
  <main class="main">
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
          <router-link class="btn" to="/universidad">
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
              <div class="col-sm-10 col-md-8 col-lg-6 col-xl-4">
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
                        @keyup.enter="buscarPersonaID"
                      />
                      <span class="input-group-append">
                        <button class="btn btn-primary" type="button" @click="buscarPersonaID">
                          <i class="fas fa-search"></i> Buscar
                        </button>
                      </span>
                    </div>
                  </div>
                </div>
                <div v-if="infoPersonaC.length">
                  <div class="card card-accent-success">
                    <div class="card-header">
                      <i class="far fa-address-card"></i> Información
                    </div>
                    <div v-for="(data, index) in infoPersonaC" :key="index">
                      <div class="card-body">
                        <form class="form-horizontal">
                          <div class="form-group row">
                            <label class="col-md-3 col-lg-4 col-sm-4 col-form-label">
                              <strong>Documento:</strong>
                            </label>
                            <div class="col-md-9 col-lg-8 col-sm-8">
                              <input
                                readonly
                                class="form-control"
                                id="vat"
                                type="text"
                                v-model="data.numero_documento"
                              />
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-3 col-lg-4 col-sm-4 col-form-label">
                              <strong>Nombres:</strong>
                            </label>
                            <div class="col-md-9 col-lg-8 col-sm-8">
                              <input
                                readonly
                                class="form-control"
                                id="vat"
                                type="text"
                                v-model="data.nombre1 ||' '|| data.nombre2"
                              />
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-3 col-lg-4 col-sm-4 col-form-label">
                              <strong>Apellidos:</strong>
                            </label>
                            <div class="col-md-9 col-lg-8 col-sm-8">
                              <input
                                readonly
                                class="form-control"
                                id="vat"
                                type="text"
                                v-model="data.apellido1 ||' '|| data.apellido2"
                              />
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-3 col-lg-4 col-sm-4 col-form-label">
                              <strong>Tipo:</strong>
                            </label>
                            <div class="col-md-9 col-lg-8 col-sm-8">
                              <input
                                readonly
                                class="form-control"
                                id="vat"
                                type="text"
                                v-model="data.tipo_persona"
                              />
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-3 col-lg-4 col-sm-4 col-form-label">
                              <strong>Estado:</strong>
                            </label>
                            <div
                              class="col-md-9 col-lg-8 col-sm-8"
                              v-if="data.estado_persona == 'Activo'"
                            >
                              <input
                                readonly
                                class="form-control is-valid"
                                id="vat"
                                type="text"
                                v-model="data.estado_persona"
                              />
                            </div>
                            <div class="col-md-9 col-lg-8 col-sm-8" v-else>
                              <input
                                readonly
                                class="form-control is-invalid"
                                id="vat"
                                type="text"
                                v-model="data.estado_persona"
                              />
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-3 col-lg-4 col-sm-4 col-form-label">
                              <strong>Sede:</strong>
                            </label>
                            <div class="col-md-9 col-lg-8 col-sm-8">
                              <input
                                readonly
                                class="form-control"
                                id="vat"
                                type="text"
                                v-model="data.sede"
                              />
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-3 col-lg-4 col-sm-4 col-form-label">
                              <strong>Programa:</strong>
                            </label>
                            <div class="col-md-9 col-lg-8 col-sm-8">
                              <input
                                readonly
                                class="form-control"
                                id="vat"
                                type="text"
                                v-model="data.programa"
                              />
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                    <div class="card-footer">
                      <div v-if="infoUserAuth[0].sedes_id == null"></div>
                      <div v-else>
                        <button class="btn btn-success btn-lg" type="submit" @click="crearIngreso">
                          <i class="fas fa-user-check"></i> Registrar Ingreso
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div v-else>
                  <div class="alert alert-warning text-center" role="alert">
                    <div class="form-group">
                      <h4>
                        <strong>¡Sin Información!</strong>
                      </h4>
                    </div>
                  </div>
                  <crearpersona class="text-center"></crearpersona>
                </div>
              </div>
              <!-- Div de ingresos actuales -->
              <div class="col-sm-12 col-md-12 col-lg-6 col-xl-8">
                <div class="card card-accent-danger">
                  <div class="card-header">
                    <h5>
                      <strong>
                        <i class="far fa-list-alt"></i>
                        Ingresos Actuales ({{objectIngresosA.total}})
                      </strong>
                    </h5>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <div class="input-group">
                            <select class="form-control" v-model="criterioA">
                              <option value="numero_documento">ID o Documento</option>
                              <option value="nombre1">Nombre</option>
                              <option value="apellido1">Apellido</option>
                            </select>
                            <!-- keydown para ejecutar cuando vayan escribiendo -->
                            <input
                              type="text"
                              placeholder="Escriba aquí"
                              v-model="buscarA"
                              class="form-control"
                              @keyup.enter="getIngresosActuales(1,criterioA,buscarA,cantidadA)"
                            />
                            <span class="input-group-append">
                              <button
                                type="button"
                                class="btn btn-primary"
                                @click="getIngresosActuales(1,criterioA,buscarA,cantidadA)"
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
                              v-model="cantidadA"
                              v-on:change="getIngresosActuales(1,criterioA,buscarA,cantidadA)"
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
                    <table class="table table-responsive-lg table-hover table-sm">
                      <thead>
                        <tr>
                          <th>Fecha Ingreso</th>
                          <th>Documento</th>
                          <th>Nombres y Apellidos</th>
                          <th>Computador</th>
                          <th>Préstamos</th>
                        </tr>
                      </thead>
                      <tbody v-if="objectIngresosA.data == ''">
                        <td colspan="5">
                          <div role="alert" class="alert alert-danger text-center">
                            <div class="form-group">
                              <strong>
                                <h5>¡Sin información!</h5>
                              </strong>
                            </div>
                          </div>
                        </td>
                      </tbody>
                      <tbody v-for="data in objectIngresosA.data" :key="data.ingresosID">
                        <tr>
                          <td>{{data.created_at | moment("DD/MM/YYYY h:mm:ss a")}}</td>
                          <td>{{data.tipo_documento}} {{data.numero_documento}}</td>
                          <td>{{data.nombre1}} {{data.nombre2}} {{data.apellido1}} {{data.apellido2}}</td>
                          <td>
                            <h4>
                              <span
                                v-if="data.estado_prestamo == 1"
                                class="badge badge-warning"
                              >{{data.nombrePC}}</span>
                              <span
                                v-if="data.estado_prestamo == 0"
                                class="badge badge-success"
                              >{{data.nombrePC}}</span>
                            </h4>
                          </td>
                          <td>
                            <div v-if="infoUserAuth[0].sedes_id == null"></div>
                            <div v-else-if="!data.estado_prestamo">
                              <button
                                type="button"
                                data-toggle="modal"
                                data-target="#modalPrestamo"
                                class="btn btn-primary"
                                @click="modalPrestarEquipo(data.ingresosID)"
                              >
                                <i class="fas fa-laptop"></i> Prestar
                              </button>
                            </div>
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
                      :data="objectIngresosA"
                      @pagination-change-page="getIngresosActuales"
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
    <div class="container-fluid" v-if="infoUserAuth.length">
      <div class="col-md-12 col-lg-12">
        <div class="card card-accent-success">
          <div class="card-header">
            <h5>
              <strong>
                <i class="far fa-list-alt"></i>
                Ingresos Totales ({{objectIngresos.total}})
              </strong>
            </h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <div class="input-group">
                    <select class="form-control" v-model="criterio">
                      <option value="numero_documento">ID o Documento</option>
                      <option value="nombre1">Nombre</option>
                      <option value="apellido1">Apellido</option>
                    </select>
                    <!-- keydown para ejecutar cuando vayan escribiendo -->
                    <input
                      type="text"
                      placeholder="Escriba aquí"
                      v-model="buscar"
                      class="form-control"
                      @keyup.enter="getIngresos(1,criterio,buscar,cantidadT)"
                    />
                    <span class="input-group-append">
                      <button
                        type="button"
                        class="btn btn-primary"
                        @click="getIngresos(1,criterio,buscar,cantidadT)"
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
                      v-model="cantidadT"
                      v-on:change="getIngresos(1,criterio,buscar,cantidadT)"
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
            <table class="table table-responsive-lg table-hover table-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Fecha Ingreso</th>
                  <th>Documento</th>
                  <th>Nombres y Apellidos</th>
                  <th>Sede</th>
                  <th>Computador</th>
                  <th>Préstamos</th>
                </tr>
              </thead>
              <tbody v-if="objectIngresos.data ==''">
                <td colspan="7">
                  <div role="alert" class="alert alert-danger text-center">
                    <div class="form-group">
                      <strong>
                        <h5>¡Sin información!</h5>
                      </strong>
                    </div>
                  </div>
                </td>
              </tbody>
              <tbody v-for="(data, index) in objectIngresos.data" :key="data.ingresosID">
                <tr>
                  <td>{{++index}}</td>
                  <td>{{data.created_at | moment("DD/MM/YYYY h:mm:ss a")}}</td>
                  <td>{{data.tipo_documento}} {{data.numero_documento}}</td>
                  <td>{{data.nombre1}} {{data.nombre2}} {{data.apellido1}} {{data.apellido2}}</td>
                  <td v-text="data.nombre_sede"></td>
                  <td>
                    <h4>
                      <span
                        v-if="data.estado_prestamo == 1"
                        class="badge badge-warning"
                      >{{data.nombrePC}}</span>
                      <span
                        v-if="data.estado_prestamo == 0"
                        class="badge badge-success"
                      >{{data.nombrePC}}</span>
                    </h4>
                  </td>
                  <td>
                    <div v-if="infoUserAuth[0].sedes_id == null"></div>
                    <div v-else-if="!data.estado_prestamo">
                      <button
                        type="button"
                        data-toggle="modal"
                        data-target="#modalPrestamo"
                        class="btn btn-primary"
                        @click="modalPrestarEquipo(data.ingresosID)"
                      >
                        <i class="fas fa-laptop"></i> Prestar
                      </button>
                    </div>
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
              :data="objectIngresos"
              @pagination-change-page="getIngresos"
              align="center"
              :limit="1"
            ></pagination>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal modal Crear prestamo-->
    <section>
      <div
        class="modal"
        id="modalPrestamo"
        role="dialog"
        aria-labelledby="myModalLabel1"
        data-backdrop="static"
        data-keyboard="false"
      >
        <div class="modal-dialog modal-primary" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">
                <i class="fas fa-laptop-code"></i> Crear Prestamó
              </h4>
              <button class="close" type="button" @click="cerrarModalPrestamo" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" enctype="multipart/form-data">
                <div class="form-group row">
                  <label class="col-md-4 col-form-label text-right" for="text-input">Computador:</label>
                  <div class="col-md-8">
                    <v-select
                      :options="arrayCompuLibres"
                      :reduce="computa => computa.id"
                      label="nombre"
                      placeholder="Seleccionar..."
                      v-model="computadores_id"
                    >
                      <div slot="no-options">No hay Resultados!</div>
                    </v-select>
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.computadores_id"
                      v-text="arrayErrors.computadores_id[0]"
                    ></span>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" @click="cerrarModalPrestamo">
                <i class="far fa-times-circle"></i> Cancelar
              </button>
              <button class="btn btn-primary" @click="crearPrestamo">
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
  </main>
</template>
<script>
//importamos para usar el mapState, mapActions
import { mapState, mapActions } from "vuex";
export default {
  data() {
    return {
      sedes_id: "",
      documento: "",
      infoPersonaU: [], //persona de la bd Unisangil
      infoPersonaC: [], //persona creada en mi bd
      objectIngresosA: {},
      //search: "",
      estado_persona: "",
      arrayErrors: [],
      arrayCompuLibres: [],
      ingresosID: "",
      computadores_id: "",
      buscar: "",
      criterio: "numero_documento",
      buscarA: "",
      criterioA: "numero_documento",
      objectIngresos: {},
      pagActual: "",
      pagActualA: "",
      cantidadA: 5,
      cantidadT: 5,
      observacion: "",
      prestamoID: ""
    };
  },
  computed: {
    ...mapState(["infoUserAuth", "infoPeriodo"])
    //metodo para filtrar el array q envio
    /* filteredList() {
      let me = this;
      return me.objectIngresosA.filter(post => {
        return (
          post.numero_documento
            .toLowerCase()
            .includes(me.search.toLowerCase()) ||
          post.nombre1.toLowerCase().includes(me.search.toLowerCase()) ||
          post.apellido1.toLowerCase().includes(me.search.toLowerCase()) ||
          post.created_at.toLowerCase().includes(me.search.toLowerCase())
        );
      });
    } */
  },
  methods: {
    ...mapActions(["getUserAuth", "getPeriodo"]),
    buscarPersonaID() {
      let me = this;
      axios
        .get("http://api.unisangil.edu.co/api/getUsuarios", {
          params: {
            id: me.documento
          }
        })
        .then(function(response) {
          me.infoPersonaU = response.data;
          if (me.infoPersonaU != "") {
            /* TIDG_ID == 1 CC, TIDG_ID == 2 TI */
            axios
              .post("/crearPersona", {
                tipo_documento: me.infoPersonaU[0].tidg_id,
                numero_documento: me.infoPersonaU[0].pege_documentoidentidad,
                nombre1: me.infoPersonaU[0].peng_primernombre,
                nombre2: me.infoPersonaU[0].peng_segundonombre,
                apellido1: me.infoPersonaU[0].peng_primerapellido,
                apellido2: me.infoPersonaU[0].peng_segundoapellido,
                estado_persona: me.infoPersonaU[0].estp_estado,
                tipo_persona: me.infoPersonaU[0].cate_descripcion,
                programa: me.infoPersonaU[0].prog_nombre,
                sede: me.infoPersonaU[0].cige_nombre,
                maac_estado: me.infoPersonaU[0].maac_estado
              })
              .then(function(response) {
                /* Swal.fire({
                  position: "top",
                  type: "success",
                  title: "Persona creada con éxito",
                  showConfirmButton: false,
                  timer: 1500
                }); */
                //console.log(response);
                axios
                  .get("/getPersona", {
                    params: {
                      id: me.infoPersonaU[0].pege_documentoidentidad
                    }
                  }) //para buscar el usuario en mi BD
                  .then(function(response) {
                    me.infoPersonaC = response.data;
                    if (!me.infoPersonaC) {
                      Swal.fire({
                        toast: true,
                        position: "top",
                        background: "#fff1d5", //warning
                        type: "warning",
                        title: "¡Persona NO ENCONTRADA!",
                        showConfirmButton: false,
                        timer: 3000
                      });
                      //console.log("No hay datos para mostrar de mi BD");
                      //console.log("No hay datos para mostrar de Unisangil");
                    } else {
                      if (me.infoPersonaC[0].estado_persona == "Activo") {
                        Swal.fire({
                          toast: true,
                          position: "top",
                          background: "#e0f1ff", //info
                          type: "info",
                          title: "Persona Activa",
                          showConfirmButton: false,
                          timer: 3000
                        });
                      } else {
                        Swal.fire({
                          toast: true,
                          position: "top",
                          background: "#fff1d5", //warning
                          type: "warning",
                          title: "Persona Inactiva!",
                          showConfirmButton: false,
                          timer: 3000
                        });
                      }
                      //console.log("Busqueda exitosa en BD");
                      //console.log("No hay datos para mostrar de Unisangil");
                    }
                  })
                  .catch(function(error) {
                    console.log(error);
                  });
              })
              .catch(function(error) {
                /* Swal.fire({
                  position: "top-end",
                  type: "error",
                  title: "Error al Crear!",
                  showConfirmButton: false,
                  timer: 1500
                }); */
                console.log(error);
              });
          } else {
            axios
              .get("/getPersona", {
                params: {
                  id: me.documento
                }
              }) //para buscar el usuario en mi BD
              .then(function(response) {
                me.infoPersonaC = response.data;
                if (me.infoPersonaC == "") {
                  Swal.fire({
                    toast: true,
                    position: "top",
                    background: "#fff1d5", //warning
                    type: "warning",
                    title: "¡Persona NO ENCONTRADA!",
                    showConfirmButton: false,
                    timer: 3000
                  });
                  //console.log("No hay datos para mostrar de mi BD");
                  //console.log("No hay datos para mostrar de Unisangil");
                } else {
                  if (me.infoPersonaC[0].estado_persona == "Activo") {
                    Swal.fire({
                      toast: true,
                      position: "top",
                      background: "#e0f1ff", //info
                      type: "info",
                      title: "Persona Activa",
                      showConfirmButton: false,
                      timer: 3000
                    });
                  } else {
                    Swal.fire({
                      toast: true,
                      position: "top",
                      background: "#fff1d5", //warning
                      type: "warning",
                      title: "Persona Inactiva!",
                      showConfirmButton: false,
                      timer: 3000
                    });
                  }
                  //console.log("Busqueda exitosa en BD");
                  //console.log("No hay datos para mostrar de Unisangil");
                }
              })
              .catch(function(error) {
                console.log(error);
              });
          }
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    getIngresos(page, criterio, buscar, cantidadT) {
      let me = this;
      //enviamos los criterios para la paginacion y igualmente el parametro buscar a la ruta, controlador pagina por la busqueda
      axios
        .get("getIngresos", {
          params: {
            page: page,
            criterio: me.criterio,
            buscar: me.buscar,
            cantidad: me.cantidadT
          }
        })
        .then(response => {
          me.objectIngresos = response.data;
          me.pagActual = response.data.current_page; //capturamos el id de la pagina actual mostrando
        });
    },
    crearIngreso() {
      let me = this;
      axios
        .post("/crearIngreso", {
          personas_id: me.infoPersonaC[0].id,
          periodos_id: me.infoPeriodo[0].id,
          users_id: me.infoUserAuth[0].id,
          sedes_id: me.infoUserAuth[0].sedes_id
        })
        .then(function(response) {
          me.getIngresosActuales(me.pagActualA, me.criterioA, me.buscarA);
          me.getIngresos(me.pagActual, me.criterio, me.buscar);
          Swal.fire({
            position: "top",
            type: "success",
            title: "Ingreso registrado con éxito",
            showConfirmButton: false,
            timer: 1500
          });
          //console.log(response);
        })
        .catch(function(error) {
          Swal.fire({
            position: "top",
            type: "error",
            title: "Error al registrar!",
            showConfirmButton: false,
            timer: 1500
          });
          console.log(error);
        });
    },

    getIngresosActuales(page, criterioA, buscarA, cantidadA) {
      let me = this;
      axios
        .get("getIngresosActuales", {
          params: {
            page: page,
            criterio: me.criterioA,
            buscar: me.buscarA,
            cantidad: me.cantidadA
          }
        })
        .then(response => {
          me.objectIngresosA = response.data;
          me.pagActualA = response.data.current_page; //capturamos el id de la pagina actual mostrando
        });
    },
    modalPrestarEquipo(ingresosID) {
      let me = this;
      me.getComputadorlibre();
      //capturo el id del ingreso
      me.ingresosID = ingresosID;
    },
    crearPrestamo() {
      let me = this;
      axios
        .post("/crearPrestamo", {
          ingresosID: me.ingresosID,
          estado_prestamo: 1,
          users_id: me.infoUserAuth[0].id,
          sedes_id: me.infoUserAuth[0].sedes_id,
          computadores_id: me.computadores_id
        })
        .then(function(response) {
          me.cerrarModalPrestamo();
          me.getIngresosActuales(me.pagActualA, me.criterioA, me.buscarA);
          me.getIngresos(me.pagActual, me.criterio, me.buscar);
          Swal.fire({
            position: "top",
            type: "success",
            title: "Prestamó creado con éxito",
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
    cerrarModalPrestamo() {
      let me = this;
      me.arrayErrors = [];
      //cerrar modal prestamo
      $("#modalPrestamo").modal("hide");
      //limpio las variables del prestamo
      me.ingresosID = "";
      me.computadores_id = "";
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
                me.getIngresosActuales(me.pagActualA, me.criterioA, me.buscarA);
                me.getIngresos(me.pagActual, me.criterio, me.buscar);
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
                console.log(error.response.data.errors);
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
          me.getIngresosActuales(me.pagActualA, me.criterioA, me.buscarA);
          me.getIngresos(me.pagActual, me.criterio, me.buscar);
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
          console.log(error);
        });
    },
    getComputadorlibre() {
      let me = this;
      axios
        .get("/getComputadorlibre")
        .then(function(response) {
          // handle success
          me.arrayCompuLibres = response.data;
          //console.log(response);
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
    },
    focus() {
      $("#buscarId").focus();
    },
    alerta() {
      Swal.fire({
        toast: true,
        position: "top",
        //background: "#f6e1e1",//error
        //background: "#d9ffe7", //success
        //background: "#fff1d5", //warning
        //background: "#e0f1ff", //info
        background: "#f5f8fb", //question
        type: "question",
        title: "No hay Servicio a buscar",
        showConfirmButton: false,
        timer: 2500
      });
    }
  },
  mounted() {
    this.getPeriodo();
    this.focus();
    //optener el Usuario autenticado
    this.getUserAuth();
    this.getIngresosActuales(
      this.pagActualA,
      this.criterioA,
      this.buscarA,
      this.cantidadA
    );
    this.getIngresos(
      this.pagActual,
      this.criterio,
      this.buscar,
      this.cantidadT
    );
  }
};
</script>
