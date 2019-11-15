<template>
  <main class="main" v-if="infoUserAuth.length">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="nav-icon icon-list"></i> Total Ingresos
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
                <router-link
                  class="btn btn-primary btn-lg mb-2"
                  title="Nuevo Ingreso"
                  to="/ingresos"
                >
                  <i class="fas fa-plus-circle"></i> Nuevo Ingreso
                </router-link>
              </div>
              <div class="col-sm-12 col-lg-12">
                <div class="card card-accent-primary">
                  <div class="card-header">
                    <h5>
                      <strong>
                        <i class="fas fa-list-ul"></i>
                        Listado de Ingresos ({{objectIngresos.total}})
                      </strong>
                    </h5>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <div class="input-group">
                            <select class="form-control" v-model="criterio">
                              <option value="numero_documento">ID o Documento</option>
                              <option value="nombre1">Nombre</option>
                              <option value="apellido1">Apellido</option>
                            </select>
                            <!-- keydown para ejecutar cuando vayan escribiendo -->
                            <input
                              type="text"
                              placeholder="Escriba aquí"
                              v-model="buscar"
                              class="form-control"
                              @keyup.enter="getIngresos(1,criterio,buscar,cantidadT)"
                            />
                            <span class="input-group-append">
                              <button
                                type="button"
                                class="btn btn-primary"
                                @click="getIngresos(1,criterio,buscar,cantidadT)"
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
                              v-model="cantidadT"
                              v-on:change="getIngresos(1,criterio,buscar,cantidadT)"
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
                    <table class="table table-responsive-lg table-hover table-sm">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Fecha Ingreso</th>
                          <th>Documento</th>
                          <th>Nombres y Apellidos</th>
                          <th>Tipo Persona</th>
                          <th>Programa</th>
                          <th>Cargo</th>
                          <th>Periodo</th>
                          <th>Sede</th>
                          <th>Computador</th>
                        </tr>
                      </thead>
                      <tbody v-if="objectIngresos.data ==''">
                        <td colspan="9">
                          <div role="alert" class="alert alert-danger text-center">
                            <div class="form-group">
                              <strong>
                                <h5>¡Sin información!</h5>
                              </strong>
                            </div>
                          </div>
                        </td>
                      </tbody>
                      <tbody v-for="(data, index) in objectIngresos.data" :key="data.ingresosID">
                        <tr>
                          <td>{{++index}}</td>
                          <td>{{data.created_at | moment("DD/MM/YYYY h:mm:ss a")}}</td>
                          <td>{{data.tipo_documento}} {{data.numero_documento}}</td>
                          <td>{{data.nombre1}} {{data.nombre2}} {{data.apellido1}} {{data.apellido2}}</td>
                          <td v-text="data.tipo_persona"></td>
                          <td v-text="data.programa"></td>
                          <td v-text="data.cargo"></td>
                          <td v-text="data.periodo"></td>
                          <td v-text="data.nombre_sede"></td>
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
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="card-footer">
                    <!-- Implementa el vue pagination para poder cambiar pagina -->
                    <pagination
                      :data="objectIngresos"
                      @pagination-change-page="getIngresos"
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
  </main>
</template>
<script>
//importamos para usar el mapState, mapActions
import { mapState, mapActions } from "vuex";
export default {
  data() {
    return {
      buscar: "",
      criterio: "numero_documento",
      objectIngresos: {},
      pagActual: "",
      cantidadT: 5
    };
  },
  computed: {
    ...mapState(["infoUserAuth"])
  },
  methods: {
    ...mapActions(["getUserAuth"]),
    getIngresos(page, criterio, buscar, cantidadT) {
      let me = this;
      //enviamos los criterios para la paginacion y igualmente el parametro buscar a la ruta, controlador pagina por la busqueda
      axios
        .get("getIngresos", {
          params: {
            page: page,
            criterio: me.criterio,
            buscar: me.buscar,
            cantidad: me.cantidadT
          }
        })
        .then(response => {
          me.objectIngresos = response.data;
          me.pagActual = response.data.current_page; //capturamos el id de la pagina actual mostrando
        });
    }
  },
  created() {
    this.getUserAuth();
    this.getIngresos(
      this.pagActual,
      this.criterio,
      this.buscar,
      this.cantidadT
    );
  }
};
</script>
