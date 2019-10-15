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
              <div class="col-md-12 col-lg-12">
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
                      <div class="col-md-6" @click="showReportData" style="cursor: pointer">
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
                      <div class="col-md-6" @click="showReportCharts" style="cursor: pointer">
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
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- seccion para mostrar los reportes -->
              <div class="col-md-12" v-if="mostrarReportes == 1">
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
                            :options="['Estudiante', 'Docente', 'Egresado', 'Particular']"
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
                          <button type="submit" class="btn btn-success" @click="descargarReporte">
                            <i class="fas fa-file-download"></i> Descargar
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-md-12" v-else-if="mostrarReportes == 2">Reportes graficos</div>
              <div class="col-md-12" v-else>
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
      programas: [
        "ESPECIALIZACIÓN EN DIDÁCTICA PARA INTEGRAR EL INGLÉS EN LOS PROCESOS EDUCATIVOS",
        "TECNOLOGIA EN SISTEMAS DE INFORMACION-SUAITA",
        "TECNOLOGIA EN SISTEMAS DE INFORMACION-MOGOTES",
        "DIPLOMADO EN APLICACIONES MOVILES (OPCION DE GRADO)",
        "TECNOLOGIA EN SISTEMAS DE INFORMACION-MUZO",
        "REQUISITOS ADICIONALES DE GRADO SAN GIL",
        "REQUISITOS ADICIONALES DE GRADO CHIQUINQUIRA",
        "DIPLOMADO GESTION AMBIENTAL Y DESARROLLO SOSTENIBLE",
        "MAESTRIA EN GERENCIA DE ORGANIZACIONES YOPAL",
        "ESP EN GERENCIA DE MTO-CONV UIS",
        "REQUISITOS ADICIONALES DE GRADO TSI",
        "INGENIERIA DE SISTEMAS - A",
        "SEMINARIO DE PROFUNDIZACION JURIDICA",
        "SEMINARIO DE ACTUALIZACION NIIF",
        "TECNOLOGIA EN SISTEMAS DE INFORMACION-CHIQUINQUIRA",
        "ADMINISTRACION DE EMPRESAS(B) CHIQUINQUIRA",
        "CONTADURIA PUBLICA (B) CHIQ",
        "INTRODUCTORIO EN CIENCIAS DE LA SALUD YOPAL",
        "MAESTRIA EN GERENCIA DE ORGANIZACIONES",
        "ESPECIALIZACION EN PEDAGOGIA PARA EL DESARROLLO DE LA INTELIGENCIA-YOPAL",
        "REQUISITOS ADICIONALES DE GRADO LICENCIATURA",
        "ESPECIALIZACION EN FINANZAS-CHIQ",
        "50% MODULOS ESPECIALIZACION DE FINANZAS-CHIQ",
        "FORMACION AUDITORES INTERNOS NTC ISO 9001:2015",
        "SEMINARIO DE ACTUALIZACIÓN EN DERECHO PROCESAL CIVIL",
        "DIPLOMADO EN GESTION DEL RIESGO OCUPACIONAL",
        "INTRODUCTORIO",
        "INGENIERIA AGRICOLA",
        "50% MODULOS ESPECIALIZACION EN ADMINISTRACION FINANCIERA ESTRATEGICA",
        "CURSO INTERNACIONAL EN MICROELECTRONICA",
        "INTRODUCTORIO EN CIENCIAS DE LA SALUD SAN GIL",
        "INTRODUCTORIO YOPAL",
        "DIPLOMADO EN DOCENCIA UNIVERSITARIA YOPAL",
        "TECNOLOGIA EN GESTION DE EMPRESAS DE ECONOMIA SOLIDARIA VILLANUEVA CASANARE",
        "DIPLOMADO EN MEDIACION PEDAGOGICA Y DERECHOS DE LA PRIMERA INFANCIA",
        "DIPLOMADO EN ORIENTACION VOCACIONAL Y PROFESIONAL",
        "DIPLOMADO EN TECNICAS DE INVESTIGACION",
        "CONTADURIA PUBLICA(B)",
        "ADMINISTRACION DE EMPRESAS(B)",
        "MOVILIDAD ACADEMICA",
        "SEMINARIO NUEVO REGIMEN DISCIPLINARIO",
        "DIPLOMADO DE GESTION PUBLICA:FORMULACION DE PROYECTOS DE INVERSION SGR",
        "TECNOLOGIA EN GESTION DE EMPRESAS DE ECONOMIA SOLIDARIA MUZO",
        "INGENIERIA DE SISTEMAS",
        "ESPECIALIZACION EN ADMINISTRACION FINANCIERA ESTRATEGICA",
        "INTRODUCTORIO A LA INGENIERIA",
        "CURSOS IDIOMAS EXTENSION",
        "TECNOLOGIA EN ANALISIS Y PROGRAMACION DE SISTEMAS DE INFORMACION SAN GIL",
        "TECNOLOGIA EN GESTION DE EMPRESAS DE ECONOMIA SOLIDARIA CHIQ",
        "CURSO AUXILIAR DE ALMACEN Y BODEGA",
        "CURSO EN CULTIVOS ENERGETICOS",
        "DIPLOMADO EN SISTEMAS DE GESTION INTEGRADOS",
        "ESPECIALIZACION EN EDUCACION BILINGUE: DIDACTICAS Y ESTRATEGIAS DEL INGLES COMO LENGUA EXTRANJERA",
        "PROGRAMAS UNAB",
        "CURSOS DE IDIOMAS",
        "DIPLOMADO EN EDUCACION BILINGUE",
        "PROGRAMA DE PEDAGOGIA PARA PROFESIONALES NO LICENCIADOS",
        "DIPLOMADO DE DERECHO COOPERATIVO, MUTUAL Y SOLIDARIO",
        "DIPLOMADO EN PRODUCCION RADIAL",
        "ADMINISTRACION DE EMPRESAS SAN GIL",
        "ADMINISTRACION DE EMPRESAS YOPAL",
        "CONTADURIA PUBLICA",
        "DERECHO",
        "DIPLOMADO EN DOCENCIA UNIVERSITARIA",
        "ENFERMERIA",
        "ESPECIALIZACION EN LA INFORMATICA EN LA EDUCACION BASICA",
        "ESPECIALIZACION EN METODOLOGIA DE LA INVESTIGACION SOCIAL Y EDUCATIVA",
        "ESPECIALIZACION EN PEDAGOGIA PARA EL DESARROLLO DE LA INTELIGENCIA",
        "INGENIERIA AMBIENTAL",
        "INGENIERIA DE MANTENIMIENTO",
        "INGENIERIA ELECTRONICA",
        "LICENCIATURA EN EDUCACION BASICA CON ENFASIS EN TECNOLOGIA E INFORMATICA SAN GIL",
        "LICENCIATURA EN EDUCACION RURAL CON ESPECIALIDAD EN DESARROLLO COMUNITARIO",
        "CURSO:EXTRACTIVOS DE BIOMASA",
        "CURSOS ESCALAFON",
        "TECNICA LABORAL EN ELECTRONICA",
        "TECNICA LABORAL EN FORESTAL",
        "TECNICA LABORAL EN PRODUCCION AGROPECUARIA Y SOSTENIBLE",
        "TECNICA PROFESIONAL EN MEDIOS AUDIOVISUALES",
        "TECNOLOGIA EN GESTION DE EMPRESAS DE ECONOMIA SOLIDARIA SAN GIL",
        "TECNOLOGIA EN GESTION TURISTICA Y HOTELERA",
        "TECNOLOGIA EN SISTEMAS SAN GIL",
        "TECNOLOGIA EN ANALISIS Y PROGRAMACION DE SISTEMAS DE INFORMACION-VILLANUEVA",
        "INGENIERA FINANCIERA UNAB",
        "ESPECIALIZACION EN FINANZAS",
        "SEMINARIO EN MODELOS FINANCIEROS EN EXCEL Y VBA",
        "CURSO FORMACION DE AUDITORES INTERNOS EN UN SGC",
        "LICENCIATURA EN EDUCACION BASICA CON ENFASIS EN TECNOLOGIA E INFORMATICA MOGOTES",
        "SEMINARIO DE ACTUALIZACION EN RIESGO EMPRESARIAL",
        "TECNICA LABORAL EN  AUXILIAR DE ALMACEN Y BODEGA",
        " DIPLOMADO DE GESTION DE EMPRESAS DE ECONOMIA SOLIDARIA",
        "TECNOLOGIA EN GESTION DE EMPRESAS DE ECONOMIA SOLIDARIA SAN ALBERTO",
        "50% MODULOS ESPECIALIZACION DE FINANZAS",
        "TECNOLOGIA EN GESTION DE EMPRESAS DE ECONOMIA SOLIDARIA SUAITA",
        "CURSO ADMINISTRACION AGENCIA DE VIAJES",
        "PSICOLOGIA UNAB-SAN GIL",
        "OTROS CURSOS",
        "DERECHO UNAB-YOPAL",
        "TECNOLOGIA EN SISTEMAS CERES MOGOTES",
        "DIPLOMADO PLANEACION PROSPECTIVA Y FORMULACION DE PROYECTOS",
        "TECNOLOGIA EN SISTEMAS CERES SUAITA",
        "DIPLOMADO HABILIDADES PARA LA VIDA",
        "SEMINARIO EN ALTA GERENCIA",
        "TECNOLOGIA EN ANALISIS Y PROGRAMACION DE SISTEMAS DE INFORMACION-SUAITA",
        "50% MODULOS EN PDI",
        "ESPECIALIZACION EN  MERCADEO ESTRATEGICO-SAN GIL",
        "SEMINARIO DE ACTUALIZACION TENDENCIAS ADMINISTRATIVAS",
        "50% MODULOS ESPECIALIZACION MERCADEO ESTRATEGICO-SAN GIL",
        "SEMINARIO DE ACTUALIZACION GERENCIAL",
        "TECNOLOGIA EN SISTEMAS DE INFORMACION-SAN GIL",
        "CURSO ACTUALIZACION NORMA ISO 19011 Y HABILI. AUDITOR",
        "SEMINARIO DE PROFUNDIZACION CON MONOGRAFIA",
        "GESTION POR PROCESOS E INDICADORES DE GESTION",
        "CURSO DE CONCILIACION",
        "TECNOLOGIA EN SISTEMAS DE INFORMACION-VILLANUEVA",
        "ESPECIALIZACION EN COMPETITIVIDAD TURISTICA",
        "PROGRAMA FORMACION CONCILIADORES",
        "DIPLOMADO DE APLICACIONES MOVILES",
        "CONTADURIA PUBLICA CHIQ",
        "DIPLOMADO EN PEDAGOGIA PARA PROFESIONALES NO LICENCIADOS",
        "REQUISITOS ADICIONALES DE GRADO YOPAL",
        "ADMINISTRACION DE EMPRESAS CHIQUINQUIRA",
        "REQUISITOS ADICIONALES DE GRADO ECOSOL",
        "CURSO INTERNACIONAL EN PROCESAMIENTO DE IMAGENES Y SU APLICACION",
        "PAMEC",
        "SEMINARIO DE ACTUALIZACION DESARROLLO GERENCIAL",
        "PSICOLOGIA UNAB-YOPAL",
        "ADMINISTRACION DE EMPRESAS (B) YOPAL",
        "SEMINARIO GERENCIA COMERCIAL",
        "Seminario de Actualizacion y Capacitacio en Atencion al Ciudadano, Relaciones Humanas y Actualizacion Juridica en materia de tr¿sito y transporte",
        "ESPECIALIZACION EN MERCADEO ESTRATEGICO-YOPAL",
        "ADMINISTRACION DE EMPRESAS TURISTICAS Y HOTELERAS",
        "50% MODULOS ESPECIALIZACION MERCADEO ESTRATEGICO YOPAL",
        "ACTUALIZACIÓN DE LA NORMA EN SEGURIDAD Y SALUD EN EL TRABAJO ISO 45001",
        "LICENCIATURA EN EDUCACION INFANTIL",
        "REQUISITOS ADICIONALES DE GRADO DERECHO CHIQUINQUIRA",
        "SEMINARIO ACTUALIZACION NIIF",
        "50% MODULOS EN PDI-YOPAL",
        "ESPECIALIZACION EN GESTION INTEGRADA DEL RECURSO HIDRICO",
        "SEMINARIO EN REDES Y MARKETING DIGITAL",
        "50% MOD ESP EN GESTION RECURSO HIDRICO",
        "GESTION DEL RIESGO: NTC ISO 31000",
        "ESPECIALIZACION EN  MERCADEO ESTRATEGICO-CHIQUINQUIRA",
        "50% MODULOS ESPECIALIZACION MERCADEO ESTRATEGICO-CHIQUINQUIRA",
        "SEMINARIO EN ACTUALIZ EN NORMA LABORALES",
        "DIPLOMADO AGUA, VIDA Y DESARROLLO",
        "PARTICULAR"
      ]
    };
  },
  computed: {
    ...mapState(["infoUserAuth"])
  },
  methods: {
    ...mapActions(["getUserAuth"]),
    showReportData() {
      let me = this;

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
    showReportCharts() {
      let me = this;

      me.mostrarReportes = 2;
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
          console.log(error);
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
          console.log(error);
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
    descargarReporte() {
      let me = this;
      if (me.periodo) {
        axios({
          url:
            "/exportAvanzado?periodo=" +
            me.periodo +
            "&tipo_persona=" +
            me.tipo_persona +
            "&programa=" +
            me.programa +
            "&sedes_id=" +
            me.sede,
          method: "GET",
          responseType: "blob" // important
        }).then(response => {
          const url = window.URL.createObjectURL(new Blob([response.data]));
          const link = document.createElement("a");
          link.href = url;
          link.setAttribute("download", "Avanzado.xlsx");
          document.body.appendChild(link);
          link.click();
          Swal.fire({
            position: "top",
            type: "success",
            title: "Descarga éxitosa!",
            showConfirmButton: false,
            timer: 1500
          }).catch(function(error) {
            if (error.response.status == 422) {
              //preguntamos si el error es 422
              me.arrayErrors = error.response.data.errors;
            }
            //console.log(error);
          });
        });
      } else {
        let fechaInicial = moment(String(me.fechaInicial)).format("YYYY-MM-DD");
        let fechaFinal = moment(String(me.fechaFinal)).format("YYYY-MM-DD");
        axios({
          url:
            "/exportAvanzado?fechaInicial=" +
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
            link.setAttribute("download", "Avanzado.xlsx");
            document.body.appendChild(link);
            link.click();
            Swal.fire({
              position: "top",
              type: "success",
              title: "Descarga éxitosa!",
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
    }
  },
  mounted() {
    this.getUserAuth();
    this.getSedes();
    this.getPeriodos();
  }
};
</script>
