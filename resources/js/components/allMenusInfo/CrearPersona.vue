<template>
  <div>
    <div class="form-group">
      <button
        type="button"
        class="btn btn-success btn-lg mb-"
        data-toggle="modal"
        data-target="#modalCrearPersona"
        data-backdrop="static"
        data-keyboard="false"
      >
        <i class="fas fa-plus-circle"></i> Crear Persona
      </button>
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
                    <v-select :options="programas" placeholder="Seleccionar..." v-model="programa">
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
              <button class="btn btn-secondary" type="button" @click="cerrarModalPersona">
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
  </div>
</template>
<script>
export default {
  data() {
    return {
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
      ],
      sede: ""
    };
  },
  methods: {
    crearPersona() {
      let me = this;
      axios
        .post("/savePersona", {
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
            position: "top",
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
      $("#modalCrearPersona").modal("hide");
      //limpiar las variables
      me.arrayErrors = [];
      me.tipo_documento = "";
      me.numero_documento = "";
      me.nombre1 = "";
      me.nombre2 = "";
      me.apellido1 = "";
      me.apellido2 = "";
      me.estado_persona = "Activo";
      me.tipo_persona = "";
      me.programa = "";
      me.sede = "";
    }
  }
};
</script>
