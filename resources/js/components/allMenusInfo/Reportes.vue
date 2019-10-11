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

                      <!-- seccion para mostrar los reportes -->
                      <div class="col-md-12" v-if="mostrarReportes == 1">Reportes de excel</div>
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
      mostrarReportes: ""
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
    },
    showReportCharts() {
      let me = this;

      me.mostrarReportes = 2;
    }
  },
  mounted() {
    this.getUserAuth();
  }
};
</script>
