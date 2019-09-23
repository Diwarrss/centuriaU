<template>
  <main class="main" v-if="infoUserAuth.length && infoPeriodo.length">
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
    <div class="container-fluid">
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
                    <button class="btn btn-success btn-lg" @click="alerta">
                      <i class="fas fa-plus-circle"></i> Crear Persona
                    </button>
                  </div>
                </div>
              </div>
              <!-- Div de ingresos actuales -->
              <div class="col-sm-12 col-md-4 col-lg-6 col-xl-8">
                <div class="card card-accent-danger">
                  <div class="card-header">
                    <i class="far fa-list-alt"></i>Ingresos Actuales
                  </div>
                  <div class="card-body">
                    <table class="table table-responsive-md table-hover table-md">
                      <thead>
                        <tr>
                          <th>Fecha Ingreso</th>
                          <th>Nombres y Apellidos</th>
                          <th>Documento</th>
                        </tr>
                      </thead>
                      <tbody v-for="data in arrayIngresosA" :key="data.id">
                        <tr>
                          <td>{{data.created_at}}</td>
                          <td>{{data.nombre1 ||' '|| data.nombre2 ||' '|| data.apellido1 ||' '|| data.apellido2}}</td>
                          <td>{{data.numero_documento}}</td>
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
      arrayIngresosA: []
    };
  },
  computed: {
    ...mapState(["infoUserAuth", "infoPeriodo"])
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
                      console.log("Busqueda exitosa en BD");
                      console.log("No hay datos para mostrar de Unisangil");
                    }
                  })
                  .catch(function(error) {
                    console.log(error);
                  })
                  .then(function() {
                    // always executed
                  });
              })
              .catch(function(error) {
                /* Swal.fire({
                  position: "top-end",
                  type: "error",
                  title: "Error al Crear!",
                  showConfirmButton: false,
                  timer: 1500
                });
                console.log(error); */
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
                  console.log("Busqueda exitosa en BD");
                  console.log("No hay datos para mostrar de Unisangil");
                }
              })
              .catch(function(error) {
                console.log(error);
              })
              .then(function() {
                // always executed
              });
          }
          /* if (me.infoPersonaU == "") {
          } else {
            if (me.infoPersonaU[0].estp_estado == "Activo") {
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
            console.log("Busqueda exitosa BD Unisangil");
          } */
        })
        .catch(function(error) {
          console.log(error);
        })
        .then(function() {
          // always executed
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
    this.focus();
    //optener el Usuario autenticado
    this.getUserAuth();
    this.getPeriodo();
    this.getIngresosActuales();
  }
};
</script>
