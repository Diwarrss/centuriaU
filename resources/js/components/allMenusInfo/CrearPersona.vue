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
                    <v-select
                      :options="['Administración de Empresas', 'Contaduría Pública', 'Administración de Empresas Turísticas y Hoteleras', 'Derecho', 'Enfermería', 'Ingeniería Agrícola', 'Ingeniería Ambiental'
                      , 'Ingeniería Electrónica', 'Ingeniería de Sistemas', 'Ingeniería de Mantenimiento', 'Ingeniería Financiera (UNAB)', 'Psicología (UNAB)', 'Tecnología en Sistemas de Información',
                      'Tecnología en Gestión de Empresas de Economía Solidaria', 'Licenciatura en educación para la primera infancia', 'Particular']"
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
