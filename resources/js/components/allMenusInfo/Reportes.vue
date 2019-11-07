<template>
  <main class="main" v-if="infoUserAuth.length">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="nav-icon icon-chart"></i> Reportes
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
    <div class="container-fluid">
      <div class="ui-view">
        <div>
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-md-4 col-lg-4">
                <div class="card card-accent-primary">
                  <div class="card-header">
                    <h5>
                      <strong>
                        <i class="fas fa-file-export"></i>
                        <i class="far fa-chart-bar"></i>
                        Generar Reportes
                      </strong>
                    </h5>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12" @click="showReportData" style="cursor: pointer">
                        <div class="card text-white bg-primary">
                          <div class="card-body">
                            <button
                              class="btn btn-transparent p-0 float-right"
                              title="Ver información"
                              @click="showReportData"
                            >
                              <i class="far fa-file-excel fa-5x"></i>
                              <i class="fas fa-file-csv fa-5x"></i>
                            </button>
                            <div class="text-value">
                              <h4>Generar reportes avanzados y exportarlos en formato Excel</h4>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- <div class="col-md-6" @click="showReportCharts" style="cursor: pointer">
                        <div class="card text-white bg-danger">
                          <div class="card-body">
                            <button
                              class="btn btn-transparent p-0 float-right"
                              title="Ver información"
                              @click="showReportCharts"
                            >
                              <i class="fas fa-chart-pie fa-5x"></i>
                              <i class="far fa-chart-bar fa-5x"></i>
                            </button>
                            <div class="text-value">
                              <h4>Parametrizar, visualizar y descargar Reportes Graficos avanzados</h4>
                            </div>
                          </div>
                        </div>
                      </div>-->
                    </div>
                  </div>
                </div>
              </div>
              <!-- seccion para mostrar los reportes -->
              <div class="col-md-8 col-lg-8" v-if="mostrarReportes == 1">
                <div class="card card-accent-success">
                  <div class="card-header">
                    <h5>
                      <strong>
                        <i class="fas fa-file-export"></i>
                        Crear Reporte de Ingresos
                      </strong>
                    </h5>
                  </div>
                  <div class="card-body">
                    <form>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">
                          <strong>Fecha Inicial:</strong>
                        </label>
                        <div class="col-sm-4">
                          <datetime
                            v-model="fechaInicial"
                            format="yyyy-MM-dd"
                            value-zone="America/Bogota"
                            @input="elegirFecha"
                          ></datetime>
                          <span
                            class="help-block text-danger"
                            v-if="arrayErrors.fechaInicial"
                            v-text="arrayErrors.fechaInicial[0]"
                          ></span>
                        </div>
                        <label class="col-sm-2 col-form-label" v-if="fechaInicial != ''">
                          <strong>Fecha Final:</strong>
                        </label>
                        <div class="col-sm-4">
                          <datetime
                            v-if="fechaInicial != ''"
                            v-model="fechaFinal"
                            format="yyyy-MM-dd"
                            value-zone="America/Bogota"
                          ></datetime>
                          <span
                            class="help-block text-danger"
                            v-if="arrayErrors.fechaFinal"
                            v-text="arrayErrors.fechaFinal[0]"
                          ></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="programa" class="col-sm-2 col-form-label">
                          <strong>Por Periodo:</strong>
                        </label>
                        <div class="col-sm-4">
                          <v-select
                            :options="periodos"
                            :reduce="periodos => periodos.id"
                            label="nombre"
                            placeholder="Seleccionar..."
                            v-model="periodo"
                            @input="elegirPeriodo"
                          >
                            <div slot="no-options">No hay Resultados!</div>
                          </v-select>
                          <span
                            class="help-block text-danger"
                            v-if="arrayErrors.periodo"
                            v-text="arrayErrors.periodo[0]"
                          ></span>
                        </div>
                        <label for="programa" class="col-sm-2 col-form-label">
                          <strong>Tipo de persona:</strong>
                        </label>
                        <div class="col-sm-4">
                            <v-select
                                :options="['Administrativo','Docente', 'Egresado','Estudiante', 'Particular']"
                                placeholder="Seleccionar..."
                                v-model="tipo_persona"
                            >
                            <div slot="no-options">No hay Resultados!</div>
                          </v-select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="programa" class="col-sm-2 col-form-label">
                          <strong>Programa:</strong>
                        </label>
                        <div class="col-sm-10">
                            <v-select
                                :options="programas"
                                :reduce="data => data.prog_nombre"
                                label="prog_nombre"
                                placeholder="Seleccionar..."
                                v-model="programa"
                            >
                            <div slot="no-options">No hay Resultados!</div>
                            </v-select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="programa" class="col-sm-2 col-form-label">
                          <strong>Por Sede:</strong>
                        </label>
                        <div class="col-sm-4">
                          <v-select
                            :options="sedes"
                            :reduce="sedes => sedes.id"
                            label="nombre"
                            placeholder="Seleccionar..."
                            v-model="sede"
                          >
                            <div slot="no-options">No hay Resultados!</div>
                          </v-select>
                        </div>
                      </div>
                      <div class="form-group row" v-if="(fechaInicial && fechaFinal) || periodo">
                        <div class="col-sm-10">
                          <button
                            type="submit"
                            class="btn btn-success"
                            id="descargar"
                            @click="descargarReporte"
                          >
                            <i class="fas fa-file-download"></i> Descargar
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <!-- <div class="col-md-12" v-else-if="mostrarReportes == 2">
                <div class="card card-accent-success">
                  <div class="card-header">
                    <h5>
                      <strong>
                        <i class="far fa-chart-bar"></i>
                        Visualizar y Parametrizar Gráficos
                      </strong>
                    </h5>
                  </div>
                  <div class="card-body"></div>
                </div>
              </div>-->
              <div class="col-md-8" v-else>
                <div role="alert" class="alert alert-success text-center">
                  <div class="form-group">
                    <h4>
                      <strong>¡Elije el tipo de reporte que deseas visualizar o generar!</strong>
                    </h4>
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
import moment from "moment";
moment.locale("es");
export default {
  data() {
    return {
      mostrarReportes: "",
      arrayErrors: [],
      fechaInicial: "",
      fechaFinal: "",
      programa: "",
      tipo_persona: "",
      sede: "",
      periodo: "",
      sedes: [],
      periodos: [],
      programas: []
    };
  },
  computed: {
    ...mapState(["infoUserAuth"])
  },
  methods: {
    ...mapActions(["getUserAuth"]),
    //obtener programas de Unisangil API
    getProgramas() {
      let me = this;
      axios
        .get("http://api.unisangil.edu.co/api/getProgramas")
        .then(res => {
          me.programas = res.data;
          //agregamos al array el campo particular
          //me.programas.push({ prog_nombre: "PARTICULAR" });
          //console.log(res);
        })
        .catch(err => {
          Swal.fire({
            position: "top",
            type: "error",
            title: "Error conexión del Servidor API",
            showConfirmButton: false,
            timer: 1500
          });
          //console.error(err);
        });
    },
    showReportData() {
      let me = this;
        me.getProgramas();
      me.mostrarReportes = 1;
      //limpiar data
      me.arrayErrors = "";
      me.fechaInicial = "";
      me.fechaFinal = "";
      me.programa = "";
      me.tipo_persona = "";
      me.sede = "";
      me.periodo = "";
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
    getPeriodos() {
      let me = this;
      axios
        .get("/getPeriodos")
        .then(function(response) {
          me.periodos = response.data;
          //console.log(me.periodos);
        })
        .catch(function(error) {
          // handle error
          //console.log(error);
        });
    },
    elegirPeriodo() {
      let me = this;
      me.fechaInicial = "";
      me.fechaFinal = "";
    },
    elegirFecha() {
      let me = this;
      me.periodo = null;
    },
    limpiarDatos() {
      let me = this;

      me.arrayErrors = "";
      me.fechaInicial = "";
      me.fechaFinal = "";
      me.programa = "";
      me.tipo_persona = "";
      me.sede = "";
      me.periodo = "";
    },
    descargarReporte() {
      let me = this;

      document.getElementById("descargar").disabled = true;
      //capturamos la fecha
      var currentDate = new Date();
      var date = currentDate.getDate();
      var month = currentDate.getMonth();
      var year = currentDate.getFullYear();
      var fechaActual = date + "/" + (month + 1) + "/" + year;

      if (me.periodo) {
        axios({
          url:
            "/exportAvanzado?" +
            "periodo=" +
            me.periodo +
            "&tipo_persona=" +
            me.tipo_persona +
            "&programa=" +
            me.programa +
            "&sedes_id=" +
            me.sede,
          method: "GET",
          responseType: "blob" // important
        })
          .then(response => {
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement("a");
            link.href = url;
            link.setAttribute(
              "download",
              fechaActual + "_ReporteIngresos.xlsx"
            );
            document.body.appendChild(link);
            link.click();
            Swal.fire({
              position: "top",
              type: "success",
              title: "Descarga éxitosa!",
              showConfirmButton: false,
              timer: 1500
            });
            me.limpiarDatos();
            document.getElementById("descargar").disabled = false;
          })
          .catch(error => {
            if (error.response.status == 422) {
              //preguntamos si el error es 422
              me.arrayErrors = error.response.data.errors;
            } else {
              Swal.fire({
                position: "top",
                type: "error",
                title: "Error al generar, Reintentar!",
                showConfirmButton: false,
                timer: 1500
              });
            }
            //console.log(error);
          });
      } else {
        let fechaInicial = moment(String(me.fechaInicial)).format("YYYY-MM-DD");
        let fechaFinal = moment(String(me.fechaFinal)).format("YYYY-MM-DD");
        axios({
          url:
            "/exportAvanzado?" +
            "fechaInicial=" +
            fechaInicial +
            "&fechaFinal=" +
            fechaFinal +
            "&tipo_persona=" +
            me.tipo_persona +
            "&programa=" +
            me.programa +
            "&sedes_id=" +
            me.sede,
          method: "GET",
          responseType: "blob" // important
        })
          .then(response => {
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement("a");
            link.href = url;
            link.setAttribute(
              "download",
              fechaActual + "_ReporteIngresos.xlsx"
            );
            document.body.appendChild(link);
            link.click();
            Swal.fire({
              position: "top",
              type: "success",
              title: "Descarga éxitosa!",
              showConfirmButton: false,
              timer: 1500
            });
            me.limpiarDatos();
            document.getElementById("descargar").disabled = false;
          })
          .catch(error => {
            if (error.response.status == 422) {
              //preguntamos si el error es 422
              me.arrayErrors = error.response.data.errors;
            } else {
              Swal.fire({
                position: "top",
                type: "error",
                title: "Error al generar, Reintentar!",
                showConfirmButton: false,
                timer: 1500
              });
            }
            //console.log(error);
          });
      }
    }
  },
  mounted() {
    this.getUserAuth();
    this.getSedes();
    this.getPeriodos();
  }
};
</script>
