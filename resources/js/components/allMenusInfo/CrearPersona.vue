<template>
  <div>
    <div class="form-group">
      <button type="button" class="btn btn-success btn-lg" @click="abrirModalPersona">
        <i class="fas fa-plus-circle"></i> Crear Persona
      </button>
    </div>
    <!-- Modal modalCrearPersona-->
    <section>
      <div
        class="modal"
        id="modalCrearPersona"
        role="dialog"
        data-backdrop="static"
        data-keyboard="false"
        aria-labelledby="myModalLabel2"
      >
        <div class="modal-dialog modal-lg modal-primary" role="document">
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
              <!-- verificamos si hay periodo activado -->
              <div v-if="!infoPeriodo.length">
                <div role="alert" class="alert alert-warning text-center">
                  <div class="form-group">
                    <strong>
                      <h3>¡No hay Periodo habilitado!</h3>
                    </strong>
                  </div>
                </div>
              </div>
              <!-- si hay periodo permite crear personas -->
              <div v-else>
                <form class="form-horizontal" enctype="multipart/form-data">
                  <div class="form-group row">
                    <label
                      class="col-md-4 col-sm-5 col-form-label font-weight-bold text-right"
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
                    <label
                      class="col-md-4 col-sm-5 col-form-label font-weight-bold text-right"
                    >Documento:</label>
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
                    <label
                      class="col-md-4 col-sm-4 col-form-label font-weight-bold text-right"
                    >Nombres:</label>
                    <div class="col-md-4 col-sm-4">
                      <input
                        class="form-control"
                        type="text"
                        v-model="nombre1"
                        placeholder="Primero"
                      />
                      <span
                        class="help-block text-danger"
                        v-if="arrayErrors.nombre1"
                        v-text="arrayErrors.nombre1[0]"
                      ></span>
                    </div>
                    <div class="col-md-4 col-sm-4">
                      <input
                        class="form-control"
                        type="text"
                        v-model="nombre2"
                        placeholder="Segundo"
                      />
                      <span
                        class="help-block text-danger"
                        v-if="arrayErrors.nombre2"
                        v-text="arrayErrors.nombre2[0]"
                      ></span>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label
                      class="col-md-4 col-sm-4 col-form-label font-weight-bold text-right"
                    >Apellidos:</label>
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
                      class="col-md-4 col-sm-5 col-form-label font-weight-bold text-right"
                      for="text-input"
                    >Estado:</label>
                    <div class="col-md-8 col-sm-7">
                      <v-select
                        :options="['Activo', 'Inactivo']"
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
                    <label
                      class="col-md-4 col-sm-5 col-form-label font-weight-bold text-right"
                    >Tipo Persona:</label>
                    <div class="col-md-8 col-sm-7">
                      <v-select
                        :options="['Administrativo','Docente', 'Egresado','Estudiante', 'Particular']"
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
                  <div v-if="tipo_persona == 'Administrativo'"></div>
                  <div class="form-group row" v-else>
                    <label
                      class="col-md-4 col-sm-5 col-form-label font-weight-bold text-right"
                    >Programa:</label>
                    <div class="col-md-8 col-sm-7">
                      <v-select
                        :options="programas"
                        :reduce="data => data.prog_nombre"
                        label="prog_nombre"
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
                  <div class="form-group row" v-if="tipo_persona == 'Administrativo'">
                    <label
                      class="col-md-4 col-sm-5 col-form-label font-weight-bold text-right"
                    >Cargo Laboral:</label>
                    <div class="col-md-8 col-sm-7">
                      <input class="form-control" type="text" v-model="cargo" />
                      <span
                        class="help-block text-danger"
                        v-if="arrayErrors.cargo"
                        v-text="arrayErrors.cargo[0]"
                      ></span>
                    </div>
                  </div>
                  <div v-else></div>
                  <div class="form-group row">
                    <label
                      class="col-md-4 col-sm-5 col-form-label font-weight-bold text-right"
                    >Sede:</label>
                    <div class="col-md-8 col-sm-7">
                      <v-select
                        :options="sedes"
                        :reduce="data => data.nombre"
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
            </div>
            <div v-if="!infoPeriodo.length"></div>
            <div class="modal-footer" v-else>
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
//importamos para usar el mapState, mapActions
import { mapState, mapActions } from "vuex";
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
      cargo: "",
      programas: [],
      sede: "",
      sedes: []
    };
  },
  created() {
    let me = this;
    //traer las sedes de mi bd
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
  computed: {
    ...mapState(["infoPeriodo"])
  },
  methods: {
    ...mapActions(["getPeriodo"]),
    //obtener programas de Unisangil API
    getProgramas() {
      let me = this;
      axios
        .get("http://apicenturia.local/api/getProgramas")
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
    abrirModalPersona() {
      this.getProgramas();
      $("#modalCrearPersona").modal("show");
    },
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
          estado: me.estado,
          tipo_persona: me.tipo_persona,
          programa: me.programa,
          sede: me.sede,
          cargo: me.cargo,
          id_periodo: me.infoPeriodo[0].id
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
      me.estado = "Activo";
      me.tipo_persona = "";
      me.programa = "";
      me.sede = "";
      me.cargo = "";
    }
  },
  mounted() {
    this.getPeriodo();
  }
};
</script>
