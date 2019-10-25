<template>
  <main class="main" v-if="infoUserAuth.length">
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
              <div v-if="infoUserAuth[0].roles_id == 4"></div>
              <div class="col-sm-12 col-lg-12" v-else>
                <crearpersona></crearpersona>
              </div>
              <div class="col-sm-12 col-lg-12">
                <div class="card card-accent-primary">
                  <div class="card-header">
                    <h5>
                      <strong>
                        <i class="fas fa-list-ul"></i>
                        Listado de Personas (Total: {{objectPersonas.total}})
                      </strong>
                    </h5>
                    <div v-if="infoUserAuth[0].roles_id == 4"></div>
                    <div class="card-header-actions" v-else>
                      <button class="btn btn-success mb-2" id="descargar" @click="descargarDatos">
                        <i class="far fa-file-excel"></i> Descargar Datos
                      </button>
                      <button class="btn btn-primary mb-2" @click="abrirImportar">
                        <i class="fas fa-file-import"></i> Importar Datos
                      </button>
                      <button class="btn btn-secondary mb-2" @click="descargarFormato">
                        <i class="fas fa-file-download"></i> Descargar Formato
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12" v-if="erroresImportar.length > 0">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                          <h4 class="alert-heading">Alertas!</h4>
                          <li
                            v-for="(data, index) in erroresImportar"
                            :key="index"
                          >{{data.errorInfo[2]}}</li>
                          <button
                            type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-label="Close"
                            @click="limpiarErrores"
                          >
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                      </div>
                      <div class="col-md-12" v-if="errores500">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <h4 class="alert-heading">Errores!</h4>
                          <li>{{errores500}}</li>
                          <button
                            type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-label="Close"
                            @click="limpiarErrores"
                          >
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <div class="input-group">
                            <!-- keydown para ejecutar cuando vayan escribiendo -->
                            <input
                              type="text"
                              placeholder="Escriba aquí"
                              v-model="buscar"
                              class="form-control"
                              @keyup.enter="getPersonas(1,buscar,cantidad)"
                            />
                            <span class="input-group-append">
                              <button
                                type="button"
                                class="btn btn-primary"
                                @click="getPersonas(1,buscar,cantidad)"
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
                              v-on:change="getPersonas(1,buscar,cantidad)"
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
                      <tbody v-for="(data, index) in objectPersonas.data" :key="data.id">
                        <tr>
                          <td>{{++index}}</td>
                          <td>{{data.tipo_documento}} {{data.numero_documento}}</td>
                          <td>{{data.nombre1}} {{data.nombre2}} {{data.apellido1}} {{data.apellido2}}</td>
                          <td v-if="data.estado_persona == 'Activo'">
                            <span class="badge badge-success" v-text="data.estado_persona"></span>
                          </td>
                          <td v-else>
                            <span class="badge badge-danger" v-text="data.estado_persona"></span>
                          </td>
                          <td v-text="data.tipo_persona"></td>
                          <td v-text="data.programa"></td>
                          <td v-text="data.sede"></td>
                          <td v-if="infoUserAuth[0].roles_id == 4"></td>
                          <td v-else>
                            <button class="btn btn-secondary" @click="abrirEditar(data)">
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
                      :data="objectPersonas"
                      @pagination-change-page="getPersonas"
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
    <!-- Modal Editar Persona-->
    <section>
      <div
        class="modal"
        id="modalEditarPersona"
        role="dialog"
        aria-labelledby="myModalLabel2"
        data-backdrop="static"
        data-keyboard="false"
      >
        <div class="modal-dialog modal-primary" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">
                <i class="far fa-edit"></i> Editar Persona
              </h4>
              <button class="close" type="button" @click="cerrarModal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" enctype="multipart/form-data">
                <div class="form-group row">
                  <label
                    class="col-md-4 col-sm-5 col-form-label font-weight-bold"
                    for="text-input"
                  >Tipo Documento:</label>
                  <div class="col-md-8 col-sm-7">
                    <v-select
                      :options="['CC', 'TI', 'CE', 'CARNET']"
                      placeholder="Seleccionar..."
                      v-model="tipo_documento"
                    >
                      <div slot="no-options">No hay Resultados!</div>
                    </v-select>
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.tipo_documento"
                      v-text="arrayErrors.tipo_documento[0]"
                    ></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-sm-5 col-form-label font-weight-bold">Documento:</label>
                  <div class="col-md-8 col-sm-7">
                    <input class="form-control" type="text" v-model="numero_documento" />
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.numero_documento"
                      v-text="arrayErrors.numero_documento[0]"
                    ></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-sm-4 col-form-label font-weight-bold">Nombres:</label>
                  <div class="col-md-4 col-sm-4">
                    <input class="form-control" type="text" v-model="nombre1" placeholder="Primero" />
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.nombre1"
                      v-text="arrayErrors.nombre1[0]"
                    ></span>
                  </div>
                  <div class="col-md-4 col-sm-4">
                    <input class="form-control" type="text" v-model="nombre2" placeholder="Segundo" />
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.nombre2"
                      v-text="arrayErrors.nombre2[0]"
                    ></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-sm-4 col-form-label font-weight-bold">Apellidos:</label>
                  <div class="col-md-4 col-sm-4">
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
                  <div class="col-md-4 col-sm-4">
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
                  <label
                    class="col-md-4 col-sm-5 col-form-label font-weight-bold"
                    for="text-input"
                  >Estado:</label>
                  <div class="col-md-8 col-sm-7">
                    <select class="form-control" v-model="estado_persona">
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
                  <label class="col-md-4 col-sm-5 col-form-label font-weight-bold">Tipo Persona:</label>
                  <div class="col-md-8 col-sm-7">
                    <v-select
                      :options="['Estudiante', 'Docente', 'Egresado', 'Particular']"
                      placeholder="Seleccionar..."
                      v-model="tipo_persona"
                    >
                      <div slot="no-options">No hay Resultados!</div>
                    </v-select>
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.tipo_persona"
                      v-text="arrayErrors.tipo_persona[0]"
                    ></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-sm-5 col-form-label font-weight-bold">Programa:</label>
                  <div class="col-md-8 col-sm-7">
                    <v-select
                      :options="['Administración de Empresas', 'Contaduría Pública', 'Administración de Empresas Turísticas y Hoteleras', 'Derecho', 'Enfermería', 'Ingeniería Agrícola', 'Ingeniería Ambiental'
                      , 'Ingeniería Electrónica', 'Ingeniería de Sistemas', 'Ingeniería de Mantenimiento', 'Ingeniería Financiera (UNAB)', 'Psicología (UNAB)', 'Tecnología en Sistemas de Información', 'Tecnología en Gestión de Empresas de Economía Solidaria', 'Licenciatura en educación para la primera infancia']"
                      placeholder="Seleccionar..."
                      v-model="programa"
                    >
                      <div slot="no-options">No hay Resultados!</div>
                    </v-select>
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.programa"
                      v-text="arrayErrors.programa[0]"
                    ></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-4 col-sm-5 col-form-label font-weight-bold">Sede:</label>
                  <div class="col-md-8 col-sm-7">
                    <v-select
                      :options="['San Gil', 'Yopal', 'Chiquinquirá']"
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
              <button class="btn btn-primary" @click="updatePersona">
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
        id="modalImportar"
        role="dialog"
        aria-labelledby="myModalLabel2"
        data-backdrop="static"
        data-keyboard="false"
      >
        <div class="modal-dialog modal-dialog-centered modal-primary" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">
                <i class="fas fa-file-import"></i> Importar Datos
              </h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" enctype="multipart/form-data">
                <div class="form-group">
                  <div class="custom-file">
                    <input
                      type="file"
                      class="custom-file-input"
                      name="imagen"
                      id="imagen"
                      @change="obtenerArchivo"
                    />
                    <label class="custom-file-label" for="file" v-if="!archivoExcel">Elegir Archivo</label>
                    <label class="custom-file-label" for="file" v-else>{{archivoExcel.name}}</label>
                    <span
                      class="help-block text-danger"
                      v-if="arrayErrors.archivo"
                      v-text="arrayErrors.archivo[0]"
                    ></span>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button
                class="btn btn-secondary"
                id="cancelarImportar"
                type="button"
                @click="cerrarImportar"
              >
                <i class="far fa-times-circle"></i> Cancelar
              </button>
              <button class="btn btn-primary" id="importarDatos" @click="importarDatos">
                <i class="far fa-check-circle"></i> Importar
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
      objectPersonas: {},
      pagActual: "1",
      cantidad: "5",
      criterio: "numero_documento",
      buscar: "",
      arrayErrors: [],
      tipo_documento: "",
      numero_documento: "",
      nombre1: "",
      nombre2: "",
      apellido1: "",
      apellido2: "",
      estado_persona: "",
      tipo_persona: "",
      programa: "",
      sede: "",
      idPersona: "",
      archivoExcel: "",
      erroresImportar: [],
      errores500: ""
    };
  },
  computed: {
    ...mapState(["infoUserAuth", "infoPeriodo"])
  },
  methods: {
    ...mapActions(["getUserAuth", "getPeriodo"]),
    //metodo para obtener las personas y el array completo
    getPersonas(page, buscar, cantidad) {
      let me = this;
      //enviamos los criterios para la paginacion y igualmente el parametro buscar a la ruta, controlador pagina por la busqueda
      axios
        .get(
          "getPersonas?page=" +
            page +
            "&buscar=" +
            me.buscar +
            "&cantidad=" +
            me.cantidad
        )
        .then(response => {
          me.objectPersonas = response.data;
          me.pagActual = response.data.current_page; //capturamos el id de la pagina actual mostrando
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
    abrirEditar(data) {
      let me = this;

      //llenamos las variables con los datos obtenidos
      me.idPersona = data["id"];
      me.tipo_documento = data["tipo_documento"];
      me.numero_documento = data["numero_documento"];
      me.nombre1 = data["nombre1"];
      me.nombre2 = data["nombre2"];
      me.apellido1 = data["apellido1"];
      me.apellido2 = data["apellido2"];
      me.estado_persona = data["estado_persona"];
      me.tipo_persona = data["tipo_persona"];
      me.programa = data["programa"];
      me.sede = data["sede"];

      me.abrirModal();
    },
    abrirModal() {
      $("#modalEditarPersona").modal("show");
    },
    cerrarModal() {
      let me = this;
      $("#modalEditarPersona").modal("hide");
      //limpiar las variables
      me.arrayErrors = [];
      me.tipo_documento = "";
      me.numero_documento = "";
      me.nombre1 = "";
      me.nombre2 = "";
      me.apellido1 = "";
      me.apellido2 = "";
      me.estado_persona = "";
      me.tipo_persona = "";
      me.programa = "";
      me.sede = "";
    },
    updatePersona() {
      let me = this;
      axios
        .post("/updatePersona", {
          id: me.idPersona,
          tipo_documento: me.tipo_documento,
          tipo_documento: me.tipo_documento,
          numero_documento: me.numero_documento,
          nombre1: me.nombre1,
          nombre2: me.nombre2,
          apellido1: me.apellido1,
          apellido2: me.apellido2,
          estado_persona: me.estado_persona,
          tipo_persona: me.tipo_persona,
          programa: me.programa,
          sede: me.sede
        })
        .then(function(response) {
          me.cerrarModal();
          me.getPersonas(me.pagActual, me.buscar); //permanecer en la pagina actual al actualizar
          Swal.fire({
            position: "top",
            type: "success",
            title: "Persona Actualizada con éxito",
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
    //generar reporte completo de excel
    descargarDatos() {
      document.getElementById("descargar").disabled = true;
      /* window.open("/exportPersonas"); //se envia a la url especifica y descarga por el controlador
      Swal.fire({
        position: "top",
        type: "success",
        title: "Descarga éxitosa!",
        showConfirmButton: false,
        timer: 1500
      }); */
      /* FORMA CON AXIOS DESCARGAR ARCHIVOS */
      axios({
        url: "/exportPersonas",
        method: "GET",
        responseType: "blob" // important
      }).then(response => {
        //capturamos la fecha
        var currentDate = new Date();
        var date = currentDate.getDate();
        var month = currentDate.getMonth();
        var year = currentDate.getFullYear();
        var fechaActual = date + "/" + (month + 1) + "/" + year;

        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", fechaActual + "_Personas.xlsx");
        document.body.appendChild(link);
        link.click();
        Swal.fire({
          position: "top",
          type: "success",
          title: "Descarga éxitosa!",
          showConfirmButton: false,
          timer: 1500
        });
        document.getElementById("descargar").disabled = false;
      });
    },
    abrirImportar() {
      $("#modalImportar").modal("show");
    },
    cerrarImportar() {
      let me = this;
      $("#modalImportar").modal("hide");
      me.arrayErrors = [];
      me.archivoExcel = "";
    },
    obtenerArchivo(e) {
      let me = this;

      let file = event.target.files[0];
      me.archivoExcel = file; //guardamos el archivo en esta variable
      //console.log(me.archivoExcel);
    },
    importarDatos() {
      //habilitar o deshabilitar botones
      document.getElementById("cancelarImportar").disabled = true;
      document.getElementById("importarDatos").disabled = true;

      let me = this;

      let formData = new FormData();
      formData.append("archivo", me.archivoExcel);

      //le enviamos formdata q lleva toda la data
      axios
        .post("/importPersonas", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        }) //le envio el parametro completo
        .then(function(response) {
          document.getElementById("cancelarImportar").disabled = false;
          document.getElementById("importarDatos").disabled = false;
          me.getPersonas(me.pagActual, me.buscar, me.cantidad);
          //si es exitoso mostramos el resultado enviado desde el server
          Swal.fire({
            position: "top",
            type: "success",
            title: "Datos cargados con éxito",
            showConfirmButton: false,
            timer: 1500
          });
          me.cerrarImportar();
          me.erroresImportar = response.data.errores;
          //console.log(me.erroresImportar);
        })
        .catch(function(error) {
          if (error.response.status == 422) {
            //preguntamos si el error es 422
            me.arrayErrors = error.response.data.errors; //guardamos la respuesta del server de errores en el array arrayErrors
            document.getElementById("cancelarImportar").disabled = false;
            document.getElementById("importarDatos").disabled = false;
          } else {
            //capturamos el error 500 servidor
            me.errores500 = error.response.data.message;
            me.cerrarImportar();
            //habilitar o deshabilitar botones
            document.getElementById("cancelarImportar").disabled = false;
            document.getElementById("importarDatos").disabled = false;
            Swal.fire({
              position: "top",
              type: "error",
              title: "Error al cargar Datos",
              showConfirmButton: false,
              timer: 1500
            });
          }
        });
    },
    descargarFormato() {
      axios({
        url: "/descargarFormato",
        method: "GET",
        responseType: "blob" // important
      }).then(response => {
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", "Formato_Personas.xlsx");
        document.body.appendChild(link);
        link.click();
        Swal.fire({
          position: "top",
          type: "success",
          title: "Descarga éxitosa!",
          showConfirmButton: false,
          timer: 1500
        });
      });
    },
    limpiarErrores() {
      this.erroresImportar = [];
      this.errores500 = "";
    }
  },
  mounted() {
    this.getUserAuth();
    this.getPersonas(this.pagActual, this.buscar, this.cantidad);
  }
};
</script>
