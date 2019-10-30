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
      arrayErrors: [],
      documento: "",
      infoPersona: [],
      programaDocente: "",
      programas: []
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
