<template>
  <main class="main" v-if="infoUserAuth.length">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="nav-icon icon-speedometer"></i> Escritorio
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
              <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-primary">
                  <div class="card-body">
                    <router-link
                      class="btn btn-transparent p-0 float-right"
                      title="Ver información"
                      to="/ingresos"
                    >
                      <i class="fas fa-user-check fa-5x"></i>
                    </router-link>
                    <div class="text-value">
                      <h3>
                        <strong>{{totalIngresos}}</strong>
                      </h3>
                    </div>
                    <div>
                      <h5>Total Ingresos</h5>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-success">
                  <div class="card-body">
                    <router-link
                      class="btn btn-transparent p-0 float-right"
                      title="Ver información"
                      to="/computadores"
                    >
                      <i class="fas fa-laptop fa-5x"></i>
                    </router-link>
                    <div class="text-value">
                      <h3>
                        <strong>{{totalComputadores}}</strong>
                      </h3>
                    </div>
                    <div>
                      <h5>Total Computadores</h5>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-info">
                  <div class="card-body">
                    <router-link
                      class="btn btn-transparent p-0 float-right"
                      title="Ver información"
                      to="/computadores"
                    >
                      <i class="fas fa-laptop-medical fa-5x"></i>
                    </router-link>
                    <div class="text-value">
                      <h3>
                        <strong>{{totalPrestamos}}</strong>
                      </h3>
                    </div>
                    <div>
                      <h5>Total de Préstamos</h5>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-danger">
                  <div class="card-body">
                    <router-link
                      class="btn btn-transparent p-0 float-right"
                      title="Ver información"
                      to="/usuarios"
                    >
                      <i class="fas fa-user-cog fa-5x"></i>
                    </router-link>
                    <div class="text-value">
                      <h3>
                        <strong>{{totalUsers}}</strong>
                      </h3>
                    </div>
                    <div>
                      <h5>Total de Usuarios del Sistema</h5>
                    </div>
                  </div>
                </div>
              </div>
              <!-- para llamar el componente del grafico -->
              <div class="col-md-6">
                <chartingresos></chartingresos>
              </div>
              <!-- para llamar el componente del grafico -->
              <div class="col-md-6">
                <chartingresosmes></chartingresosmes>
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
      totalIngresos: "",
      totalComputadores: "",
      totalPrestamos: "",
      totalUsers: ""
    };
  },
  computed: {
    ...mapState(["infoUserAuth"])
  },
  methods: {
    ...mapActions(["getUserAuth"]),
    getCantidades() {
      let me = this;
      axios
        .get("/countIngresos")
        .then(function(response) {
          me.totalIngresos = response.data;
          //console.log(response);
        })
        .catch(function(error) {
          console.log(error);
        });

      axios
        .get("/countComputadores")
        .then(function(response) {
          me.totalComputadores = response.data;
          //console.log(response);
        })
        .catch(function(error) {
          console.log(error);
        });

      axios
        .get("/countPrestamos")
        .then(function(response) {
          me.totalPrestamos = response.data;
          //console.log(response);
        })
        .catch(function(error) {
          console.log(error);
        });

      axios
        .get("/countUsers")
        .then(function(response) {
          me.totalUsers = response.data;
          //console.log(response);
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  },
  mounted() {
    this.getUserAuth();
    this.getCantidades();
  }
};
</script>
