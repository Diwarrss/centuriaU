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
          <a class="btn" href="#">
            <i class="icon-settings"></i> Configuración
          </a>
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
                    <i class="icon-magnifier icons"></i>Buscar Persona
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
                      <button class="btn btn-success" type="submit" @click="crearIngreso">
                        <i class="fas fa-user-check"></i> Registrar Ingreso
                      </button>
                    </div>
                  </div>
                </div>
                <div v-else class="alert alert-warning text-center" role="alert">
                  <div class="form-group">
                    <strong>¡Sin Información!</strong>
                  </div>
                  <div class="form-group">
                    <button
                      type="button"
                      class="btn btn-success btn-lg"
                      data-toggle="modal"
                      data-target="#modalCrearPersona"
                    >
                      <i class="fas fa-plus-circle"></i> Crear Persona
                    </button>
                  </div>
                </div>
              </div>
              <!-- Div de ingresos actuales -->
              <div class="col-sm-12 col-md-12 col-lg-6 col-xl-8">
                <div class="card card-accent-danger">
                  <div class="card-header">
                    <i class="far fa-list-alt"></i>Ingresos Actuales
                    <div class="card-header-actions">
                      <div class="form-group">
                        <input
                          class="form-control"
                          v-model="search"
                          type="text"
                          placeholder="Buscar..."
                        />
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <table class="table table-responsive-md table-hover table-md">
                      <thead>
                        <tr>
                          <th>Fecha Ingreso</th>
                          <th>Documento</th>
                          <th>Nombres y Apellidos</th>
                          <th>Computador</th>
                          <th>Accion</th>
                        </tr>
                      </thead>
                      <tbody v-if="!arrayIngresosA.length">
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
                      <tbody v-for="data in filteredList" :key="data.ingresosID">
                        <tr>
                          <td>{{data.created_at | moment("DD/MM/YYYY h:mm:ss a")}}</td>
                          <td>{{data.numero_documento}}</td>
                          <td>{{data.nombre1}} {{data.nombre2}} {{data.apellido1}} {{data.apellido2}}</td>
                          <td class="text-center">
                            <h4>
                              <span class="badge badge-secondary">{{data.nombrePC}}</span>
                            </h4>
                          </td>
                          <td>
                            <div v-if="!data.estado_prestamo || data.estado_prestamo==0">
                              <button
                                type="button"
                                data-toggle="modal"
                                data-target="#modalPrestamo"
                                class="btn btn-primary"
                                @click="modalPrestarEquipo(data.ingresosID)"
                              >
                                <i class="fas fa-laptop"></i> Prestamó
                              </button>
                            </div>
                            <div v-else-if="data.estado_prestamo == 1">
                              <button class="btn btn-success">
                                <i class="far fa-check-circle"></i> Entregado
                              </button>
                            </div>
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
    <!-- Modal modalCrearPersona-->
    <section>
      <div class="modal" id="modalCrearPersona" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-primary" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">
                <i class="fas fa-user-edit"></i> Crear Persona
              </h4>
              <button class="close" type="button" @click="cerrarModalPersona" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" enctype="multipart/form-data">
                <div class="form-group row">
                  <label class="col-md-4 col-form-label text-right" for="text-input">Tipo Documento</label>
                  <div class="col-md-8">
                    <v-select
                      :options="['CC', 'TI', 'CE', 'CARNET']"
                      placeholder="Seleccionar..."
                      v-model="tipo_documento"
                    ></v-select>
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.tipo_documento"
                      v-text="arrayErrors.tipo_documento[0]"
                    ></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-form-label text-right">Documento</label>
                  <div class="col-md-8">
                    <input class="form-control" type="text" v-model="numero_documento" />
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.numero_documento"
                      v-text="arrayErrors.numero_documento[0]"
                    ></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-form-label text-right">Nombres</label>
                  <div class="col-md-4">
                    <input class="form-control" type="text" v-model="nombre1" placeholder="Primero" />
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.nombre1"
                      v-text="arrayErrors.nombre1[0]"
                    ></span>
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="text" v-model="nombre2" placeholder="Segundo" />
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.nombre2"
                      v-text="arrayErrors.nombre2[0]"
                    ></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-form-label text-right">Apellidos</label>
                  <div class="col-md-4">
                    <input
                      class="form-control"
                      type="text"
                      v-model="apellido1"
                      placeholder="Primero"
                    />
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.apellido1"
                      v-text="arrayErrors.apellido1[0]"
                    ></span>
                  </div>
                  <div class="col-md-4">
                    <input
                      class="form-control"
                      type="text"
                      v-model="apellido2"
                      placeholder="Segundo"
                    />
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.apellido2"
                      v-text="arrayErrors.apellido2[0]"
                    ></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-form-label text-right" for="text-input">Estado</label>
                  <div class="col-md-8">
                    <select class="form-control" v-model="estado">
                      <option value="Activo" selected>Activo</option>
                      <option value="Inactivo">Inactivo</option>
                    </select>
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.estado_persona"
                      v-text="arrayErrors.estado_persona[0]"
                    ></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-form-label text-right">Tipo Persona</label>
                  <div class="col-md-8">
                    <v-select
                      :options="['Estudiante', 'Docente', 'Egresado', 'Particular']"
                      placeholder="Seleccionar..."
                      v-model="tipo_persona"
                    ></v-select>
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.tipo_persona"
                      v-text="arrayErrors.tipo_persona[0]"
                    ></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-form-label text-right">Programa</label>
                  <div class="col-md-8">
                    <v-select
                      :options="['Administración de Empresas', 'Contaduría Pública', 'Administración de Empresas Turísticas y Hoteleras', 'Derecho', 'Enfermería', 'Ingeniería Agrícola', 'Ingeniería Ambiental'
                      , 'Ingeniería Electrónica', 'Ingeniería de Sistemas', 'Ingeniería de Mantenimiento', 'Ingeniería Financiera (UNAB)', 'Psicología (UNAB)', 'Tecnología en Sistemas de Información', 'Tecnología en Gestión de Empresas de Economía Solidaria', 'Licenciatura en educación para la primera infancia']"
                      placeholder="Seleccionar..."
                      v-model="programa"
                    ></v-select>
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.programa"
                      v-text="arrayErrors.programa[0]"
                    ></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-form-label text-right">Sede</label>
                  <div class="col-md-8">
                    <v-select
                      :options="['San Gil', 'Yopal', 'Chiquinquirá']"
                      placeholder="Seleccionar..."
                      v-model="sede"
                    ></v-select>
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
              <button class="btn btn-secondary" type="button" data-dismiss="modal">
                <i class="far fa-times-circle"></i> Cancelar
              </button>
              <button class="btn btn-primary" @click="crearPersona">
                <i class="far fa-check-circle"></i> Guardar
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Modal modalCrearPersona-->
    <section>
      <div class="modal" id="modalPrestamo" role="dialog" aria-labelledby="myModalLabel1">
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
                    ></v-select>
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
      infoPersonaC: [], //persona creada en mi bd
      arrayIngresosA: [],
      search: "",
      estado_persona: "",
      arrayErrors: [],
      tipo_documento: "",
      numero_documento: "",
      nombre1: "",
      nombre2: "",
      apellido1: "",
      apellido2: "",
      estado: "Activo",
      tipo_persona: "",
      programa: "",
      sede: "",
      arrayCompuLibres: [],
      ingresosID: "",
      computadores_id: ""
    };
  },
  computed: {
    ...mapState(["infoUserAuth", "infoPeriodo"]),
    //metodo para filtrar el array q envio
    filteredList() {
      let me = this;
      return me.arrayIngresosA.filter(post => {
        return (
          post.numero_documento
            .toLowerCase()
            .includes(me.search.toLowerCase()) ||
          post.nombre1.toLowerCase().includes(me.search.toLowerCase()) ||
          post.apellido1.toLowerCase().includes(me.search.toLowerCase()) ||
          post.created_at.toLowerCase().includes(me.search.toLowerCase())
        );
      });
    }
  },
  methods: {
    ...mapActions(["getUserAuth", "getPeriodo"]),
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
                sede: me.infoPersonaU[0].cige_nombre
              })
              .then(function(response) {
                /* Swal.fire({
                  position: "top-end",
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
                        position: "top-end",
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
                          position: "top-end",
                          background: "#e0f1ff", //info
                          type: "info",
                          title: "Persona Activa",
                          showConfirmButton: false,
                          timer: 3000
                        });
                      } else {
                        Swal.fire({
                          toast: true,
                          position: "top-end",
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
                    position: "top-end",
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
                      position: "top-end",
                      background: "#e0f1ff", //info
                      type: "info",
                      title: "Persona Activa",
                      showConfirmButton: false,
                      timer: 3000
                    });
                  } else {
                    Swal.fire({
                      toast: true,
                      position: "top-end",
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
          me.getIngresosActuales();
          Swal.fire({
            position: "top-end",
            type: "success",
            title: "Ingreso registrado con éxito",
            showConfirmButton: false,
            timer: 1500
          });
          //console.log(response);
        })
        .catch(function(error) {
          Swal.fire({
            position: "top-end",
            type: "error",
            title: "Error al registrar!",
            showConfirmButton: false,
            timer: 1500
          });
          console.log(error);
        });
    },
    crearPersona() {
      let me = this;
      axios
        .post("/savePersona", {
          tipo_documento: me.tipo_documento,
          tipo_documento: me.tipo_documento,
          numero_documento: me.numero_documento,
          nombre1: me.nombre1,
          nombre2: me.nombre2,
          apellido1: me.apellido1,
          apellido2: me.apellido2,
          estado_persona: me.estado,
          tipo_persona: me.tipo_persona,
          programa: me.programa,
          sede: me.sede
        })
        .then(function(response) {
          me.cerrarModalPersona();
          Swal.fire({
            position: "top-end",
            type: "success",
            title: "Persona Creada con éxito",
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
    cerrarModalPersona() {
      let me = this;
      //$("[data-dismiss=modal]").trigger({ type: "click" });
      //limpiar las variables
      (me.arrayErrors = []),
        (me.tipo_documento = ""),
        (me.numero_documento = ""),
        (me.nombre1 = ""),
        (me.nombre2 = ""),
        (me.apellido1 = ""),
        (me.apellido2 = ""),
        (me.estado_persona = "Activo"),
        (me.tipo_persona = ""),
        (me.programa = ""),
        (me.sede = "");
    },
    getIngresosActuales() {
      let me = this;
      axios
        .get("/getIngresosActuales")
        .then(function(response) {
          // handle success
          me.arrayIngresosA = response.data;
          //console.log(response);
        })
        .catch(function(error) {
          // handle error
          console.log(error);
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
          me.getIngresosActuales();
          Swal.fire({
            position: "top-end",
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
      //cerrar modal prestamo
      $("[data-dismiss=modal]").trigger({ type: "click" });
      //limpio las variables del prestamo
      me.ingresosID = "";
      me.computadores_id = "";
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
        position: "top-end",
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
    this.getIngresosActuales();
  }
};
</script>
