<template>
  <main class="main">
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
          <router-link class="btn" to="/universidad">
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
                      <i class="fas fa-user-check fa-4x"></i>
                    </router-link>
                    <div class="text-value">{{totalIngresos}}</div>
                    <div>Total Ingresos</div>
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
                      <i class="fas fa-laptop fa-4x"></i>
                    </router-link>
                    <div class="text-value">{{totalComputadores}}</div>
                    <div>Total Computadores</div>
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
                      <i class="fas fa-laptop-medical fa-4x"></i>
                    </router-link>
                    <div class="text-value">{{totalPrestamos}}</div>
                    <div>Total de Préstamos</div>
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
export default {
  data() {
    return {
      totalIngresos: "",
      totalComputadores: "",
      totalPrestamos: ""
    };
  },
  computed: {},
  methods: {
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
    }
  },
  mounted() {
    this.getCantidades();
  }
};
</script>
