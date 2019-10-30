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
              <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                <div v-if="infoUserAuth[0].roles_id == 4"></div>
                <div v-else>
                  <crearpersona></crearpersona>
                </div>
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
                        placeholder="Número de Documento"
                        id="buscarDocumento"
                        v-model="documento"
                        @keyup.enter="buscarPersona"
                      />
                      <span class="input-group-append">
                        <button class="btn btn-primary" type="button" @click="buscarPersona">
                          <i class="fas fa-search"></i> Buscar
                        </button>
                      </span>
                    </div>
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.documento"
                      v-text="arrayErrors.documento[0]"
                    ></span>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-12">
                <div
                  v-if="infoPersona.Persona || infoPersona.Administrativo || infoPersona.Estudiante"
                >
                  <div class="card card-accent-success">
                    <div class="card-header">
                      <h5>
                        <strong>
                          <i class="icon-info icons"></i> Información de Persona a Ingresar
                        </strong>
                      </h5>
                    </div>
                    <div class="card-body">
                      <table class="table table-responsive-lg table-hover table-sm">
                        <thead>
                          <tr>
                            <th>Tipo</th>
                            <th>Documento</th>
                            <th>Nombres y Apellidos</th>
                            <th>Estado</th>
                            <th>Tipo Persona</th>
                            <th style="width: 350px">Programa</th>
                            <th>Cargo</th>
                            <th>Ciudad</th>
                            <th>Acción</th>
                          </tr>
                        </thead>
                        <!-- creamos lo vfor en tr para no duplicar los index en la tabla y q sean unicos -->
                        <tbody>
                          <tr v-for="(data, index) in infoPersona.Persona" :key="index">
                            <td v-text="data.tipo_documento"></td>
                            <td v-text="data.numero_documento"></td>
                            <td>{{data.nombre1}} {{data.nombre2}} {{data.apellido1}} {{data.apellido2}}</td>
                            <td>
                              <span
                                v-if="data.estado_persona == 'Activo'"
                                class="badge badge-success"
                              >{{data.estado_persona}}</span>
                              <span v-else class="badge badge-danger">{{data.estado_persona}}</span>
                            </td>
                            <td v-text="data.tipo_persona"></td>
                            <td v-text="data.programa"></td>
                            <td v-text="data.cargo"></td>
                            <td v-text="data.sede"></td>
                            <td>
                              <!-- <button
                                @click="eliminarPersona(index)"
                                type="button"
                                class="btn btn-danger"
                                title="Eliminar"
                              >
                                <i class="fas fa-window-close"></i>
                              </button>-->
                            </td>
                          </tr>
                        </tbody>
                        <tbody>
                          <tr v-for="(data,index) in infoPersona.Administrativo" :key="index">
                            <td v-text="data.tidg_abreviatura"></td>
                            <td v-text="data.pege_documentoidentidad"></td>
                            <td>{{data.peng_primernombre}} {{data.peng_segundonombre}} {{data.peng_primerapellido}} {{data.peng_segundoapellido}}</td>
                            <td>
                              <span
                                v-if="data.estado == 'ACTIVO'"
                                class="badge badge-success"
                              >{{data.estado}}</span>
                              <span v-else class="badge badge-danger">{{data.estado}}</span>
                            </td>
                            <td v-if="data.cargo == 'DOCENTE'">Docente</td>
                            <td v-else>Administrativo</td>
                            <td v-if="data.cargo == 'DOCENTE' && !data.programa">
                              <v-select
                                @input="addProgramaDocente(programaDocente, index)"
                                :options="programas"
                                :reduce="data => data.prog_nombre"
                                label="prog_nombre"
                                placeholder="Seleccionar..."
                                v-model="programaDocente"
                              >
                                <div slot="no-options">No hay Resultados!</div>
                              </v-select>
                            </td>
                            <td v-else-if="data.programa != ''">{{data.programa}}</td>
                            <td v-text="data.cargo"></td>
                            <td v-text="data.ciudad"></td>
                            <td>
                              <button
                                @click="eliminarPersona(index)"
                                type="button"
                                class="btn btn-danger"
                                title="Eliminar"
                              >
                                <i class="fas fa-window-close"></i>
                              </button>
                            </td>
                          </tr>
                        </tbody>
                        <tbody>
                          <tr v-for="(data,index) in infoPersona.Estudiante" :key="index">
                            <td v-text="data.tidg_abreviatura"></td>
                            <td v-text="data.pege_documentoidentidad"></td>
                            <td>{{data.peng_primernombre}} {{data.peng_segundonombre}} {{data.peng_primerapellido}} {{data.peng_segundoapellido}}</td>
                            <td>
                              <span
                                v-if="data.estadoestudiante == 'Inactivo' && data.matriculaestado == null"
                                class="badge badge-danger"
                              >Inactivo</span>
                              <span
                                v-else-if="data.matriculaestado == null && data.tipoestudiante != 'CONTINUIDAD ACADEMICA - EGRESADO' && data.estadoestudiante == 'Inactivo'"
                                class="badge badge-danger"
                              >Inactivo</span>
                              <span
                                v-else-if="data.tipoestudiante == 'CONTINUIDAD ACADEMICA - EGRESADO'"
                                class="badge badge-success"
                              >Activo</span>
                              <span
                                v-else-if="data.estadoestudiante == 'Activo' && data.matriculaestado == null"
                                class="badge badge-success"
                              >Activo</span>
                              <span v-else class="badge badge-success">Activo</span>
                            </td>
                            <td
                              v-if="data.tipoestudiante == 'CONTINUIDAD ACADEMICA - EGRESADO'"
                            >Egresado</td>
                            <td v-else>Estudiante</td>
                            <td v-text="data.programa"></td>
                            <td></td>
                            <td v-text="data.ciudad"></td>
                            <td>
                              <!-- <button
                                @click="eliminarPersona(index)"
                                type="button"
                                class="btn btn-danger"
                                title="Eliminar"
                              >
                                <i class="fas fa-window-close"></i>
                              </button>-->
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div v-if="infoUserAuth[0].sedes_id == null || infoUserAuth[0].roles_id == 4"></div>
                    <div
                      v-else-if="infoUserAuth[0].sedes_id == null || infoUserAuth[0].roles_id == 4"
                    ></div>
                    <div
                      v-else-if="infoUserAuth[0].sedes_id == null || infoUserAuth[0].roles_id == 4"
                    ></div>
                    <div v-else class="card-footer">
                      <button
                        class="btn btn-success btn-lg"
                        type="submit"
                        @click="crearIngreso(infoPersona)"
                      >
                        <i class="fas fa-user-check"></i> Registrar Ingreso
                      </button>
                    </div>
                  </div>
                </div>
                <div v-else-if="!infoPersona.length">
                  <div class="alert alert-warning text-center" role="alert">
                    <div class="form-group">
                      <h4>
                        <strong>¡Sin Información!</strong>
                      </h4>
                    </div>
                  </div>
                </div>
                <div v-else-if="!infoPersona.Persona.length">
                  <div class="alert alert-warning text-center" role="alert">
                    <div class="form-group">
                      <h4>
                        <strong>¡Sin Información!</strong>
                      </h4>
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
                </div>
              </div>
              <!-- Div de ingresos actuales -->
              <div class="col-sm-12 col-md-12 col-lg-12">
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
                    <table class="table table-responsive-md table-hover table-sm">
                      <thead>
                        <tr>
                          <th>Fecha Ingreso</th>
                          <th>Documento</th>
                          <th>Nombres y Apellidos</th>
                          <th>Tipo Personas</th>
                          <th>Programas</th>
                          <th>Computador</th>
                          <th>Préstamos</th>
                        </tr>
                      </thead>
                      <tbody v-if="objectIngresosA.data == ''">
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
                      <tbody v-for="data in objectIngresosA.data" :key="data.ingresosID">
                        <tr>
                          <td>{{data.created_at | moment("DD/MM/YYYY h:mm:ss a")}}</td>
                          <td>{{data.tipo_documento}} {{data.numero_documento}}</td>
                          <td>{{data.nombre1}} {{data.nombre2}} {{data.apellido1}} {{data.apellido2}}</td>
                          <td v-text="data.tipo_persona"></td>
                          <td v-text="data.programas"></td>
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
                            <div
                              v-if="infoUserAuth[0].sedes_id == null || infoUserAuth[0].roles_id == 4"
                            ></div>
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
      arrayErrors: [],
      documento: "",
      infoPersona: [],
      programaDocente: "",
      programas: [],
      //ingresos actuales
      objectIngresosA: {},
      criterioA: "numero_documento",
      buscarA: "",
      cantidadA: 5,
      pagActualA: "",
      //prestamo de Equipos
      arrayCompuLibres: [],
      computadores_id: "",
      observacion: ""
    };
  },
  computed: {
    ...mapState(["infoUserAuth", "infoPeriodo"])
  },
  methods: {
    ...mapActions(["getUserAuth", "getPeriodo"]),
    focus() {
      $("#buscarDocumento").focus();
    },
    //obtener programas de Unisangil API
    getProgramas() {
      let me = this;
      axios
        .get("http://apicenturia.local/api/getProgramas")
        .then(res => {
          me.programas = res.data;
          //agregamos al array el campo particular
          me.programas.push({ prog_nombre: "PARTICULAR" });
          //console.log(res);
        })
        .catch(err => {
          Swal.fire({
            position: "top",
            type: "error",
            title: "Error conexión del Servidor API",
            showConfirmButton: false,
            timer: 3000
          });
          //console.error(err);
        });
    },
    buscarPersona() {
      let me = this;
      me.infoPersona = [];
      axios
        .get("http://apicenturia.local/api/getUsuarios", {
          params: {
            documento: me.documento
          }
        })
        .then(function(response) {
          me.infoPersona = response.data;
          //si no hay datos de unisangil al buscar
          if (
            me.infoPersona.Administrativo == "" &&
            me.infoPersona.Estudiante == ""
          ) {
            //vaciamos el objeto x q no hay datos de unisangil
            me.infoPersona = [];
            /* Swal.fire({
              position: "top-end",
              type: "warning",
              title: "Unisangil sin Información",
              showConfirmButton: false,
              timer: 3000
            }); */
            //realizamos busqueda en nuestra base de datos
            axios
              .get("/getPersona", {
                params: {
                  documento: me.documento,
                  id_periodo: me.infoPeriodo[0].id
                }
              })
              .then(res => {
                me.infoPersona = res.data;
                //console.log(res);

                //si no hay datos en mi BD no hay ninguna persona con ese documento
                if (me.infoPersona.Persona == "") {
                  //vaciamos el objeto x q no hay datos de ninguna base de datos
                  me.infoPersona = [];
                  Swal.fire({
                    toast: true,
                    position: "top-end",
                    type: "error",
                    title: "No hay Resultados!",
                    showConfirmButton: false,
                    timer: 3000
                  });
                }
                //si hay informacion la mostramos
                else {
                  me.arrayErrors = [];
                  Swal.fire({
                    toast: true,
                    position: "top-end",
                    type: "success",
                    title: "Información Recibida de BD Local",
                    showConfirmButton: false,
                    timer: 3000
                  });
                }
              })
              .catch(err => {
                if (err.response.status == 422) {
                  //preguntamos si el error es 422
                  me.arrayErrors = err.response.data.errors;
                }
                //console.error(err);
              });
          }
          //si hay datos de unisangil al buscar
          else {
            me.arrayErrors = [];
            me.getProgramas();
            Swal.fire({
              toast: true,
              position: "top-end",
              type: "success",
              title: "Información Recibida de Unisangil",
              showConfirmButton: false,
              timer: 3000
            });
          }
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
    //metodo para agregar al array un programa al docente
    addProgramaDocente(programa, index) {
      let me = this;
      //variable para verificar si existe docente con programa una vez
      let existe = false;
      //console.log(programa, index);
      me.programaDocente = null;
      //creamos variable y capturamos la info de admin de docente
      const dataDocente = me.infoPersona.Administrativo;

      //console.log(dataDocente);

      //realizamos recorrido el objeto para validar q ese programa no existe
      Object.keys(dataDocente).forEach(function(key) {
        if (programa == dataDocente[key].programa) {
          existe = true;
          //console.log(existe);
        } else {
          existe = false;
          //console.log(existe);
        }
        //console.log("Programa no existe");
        //console.log(key, dataDocente[key]);
      });

      if (existe) {
        Swal.fire({
          position: "top-end",
          type: "warning",
          title: "Docente ya tiene este programa asignado",
          showConfirmButton: false,
          timer: 3000
        });
      } else {
        //agregamos los datos al array Administrativo cuando es Docente
        me.infoPersona.Administrativo.push({
          cargo: "DOCENTE",
          ciudad: dataDocente[0].ciudad,
          estado: dataDocente[0].estado,
          labo_descripcion: dataDocente[0].labo_descripcion,
          pege_documentoidentidad: dataDocente[0].pege_documentoidentidad,
          peng_primerapellido: dataDocente[0].peng_primerapellido,
          peng_primernombre: dataDocente[0].peng_primernombre,
          peng_segundoapellido: dataDocente[0].peng_segundoapellido,
          peng_segundonombre: dataDocente[0].peng_segundonombre,
          tidg_abreviatura: dataDocente[0].tidg_abreviatura,
          tidg_id: dataDocente[0].tidg_id,
          programa: programa
        });
      }
    },
    eliminarPersona(index) {
      let me = this;
      //eliminamos del Array Administrativos los que elijan
      me.infoPersona.Administrativo.splice(index, 1);
      Swal.fire({
        toast: true,
        position: "top",
        background: "#d9ffe7", //warning
        type: "success",
        title: "Eliminado de la lista",
        showConfirmButton: false,
        timer: 3000
      });
      //console.log("borrado");
    },
    crearIngreso(infoPersona) {
      let me = this;
      if (!infoPersona) {
        Swal.fire({
          position: "top",
          type: "error",
          title: "Alerta!, no hay datos!",
          showConfirmButton: false,
          timer: 3000
        });
      } else {
        //vamos a crear un solo array por todos los que recibimos excluyendo si el Tipo Persona es Docente y no tiene programa
        if (!infoPersona.Persona) {
          //capturamos los arrays y los unimos en unos solo
          const data = infoPersona.Administrativo.concat(
            infoPersona.Estudiante
          );
          //variable para caprutar el index del array
          let keyData;
          //console.log(data);
          //realizamos recorrido el objeto para validar  si el docente lleva programa o no y se elimina de la data
          Object.keys(data).forEach(function(key) {
            //console.log(data[key].cargo);
            if (data[key].cargo == "DOCENTE" && data[key].programa == null) {
              keyData = key;
            }
          });

          //si keyData contiene un valor eliminamos del array
          if (keyData) {
            data.splice(keyData, 1);
            //console.log(data);
          } else {
            //console.log(data);
            //console.log("Array completo");
          }
          //Se realiza el envio por POST para realizar el ingreso
          axios
            .post("/crearIngreso", {
              data,
              id_periodo: me.infoPeriodo[0].id
            })
            .then(res => {
              me.getIngresosActuales(me.pagActualA, me.criterioA, me.buscarA);
              Swal.fire({
                position: "top",
                type: "success",
                title: "Ingreso registrado con éxito",
                showConfirmButton: false,
                timer: 1500
              });
              me.limpiarBusqueda();
              //console.log(res);
            })
            .catch(err => {
              Swal.fire({
                position: "top",
                type: "error",
                title: "Error al realizar Ingreso!",
                showConfirmButton: false,
                timer: 1500
              });
              me.limpiarBusqueda();
              //console.error(err);
            });
        } else {
          let data = infoPersona.Persona;
          //Se realiza el envio por POST para realizar el ingreso
          axios
            .post("/crearIngresoBD", {
              data,
              id_periodo: me.infoPeriodo[0].id
            })
            .then(res => {
              me.getIngresosActuales(me.pagActualA, me.criterioA, me.buscarA);
              Swal.fire({
                position: "top",
                type: "success",
                title: "Ingreso registrado con éxito",
                showConfirmButton: false,
                timer: 1500
              });
              me.limpiarBusqueda();
              //console.log(res);
            })
            .catch(err => {
              Swal.fire({
                position: "top",
                type: "error",
                title: "Error al realizar Ingreso!",
                showConfirmButton: false,
                timer: 1500
              });
              me.limpiarBusqueda();
              //console.error(err);
            });
        }
      }
    },
    limpiarBusqueda() {
      this.infoPersona = [];
      this.focus();
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

    //todo lo relacionado con prestamos
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
          me.getIngresosActuales(me.pagActualA, me.criterioA, me.buscarA);
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
          //console.log(error);
        });
    }
  },
  mounted() {
    this.getPeriodo();
    //optener el Usuario autenticado
    this.getUserAuth();
    this.focus();
    this.getIngresosActuales(
      this.pagActualA,
      this.criterioA,
      this.buscarA,
      this.cantidadA
    );
  }
};
</script>
