<template>
  <div class="card">
    <div class="card-header">
      <h5>
        <strong>
          <i class="fas fa-chart-bar"></i>
          Ingresos por Mes ({{new Date().getFullYear()}})
          <!-- obtener año actual -->
        </strong>
      </h5>
    </div>
    <div class="card-body">
      <div v-if="series.length > 0">
        <apexchart width="100%" height="auto" :options="options" :series="series"></apexchart>
      </div>
    </div>
  </div>
</template>
<script>
//import vue charts desde apexcharts completo
import VueApexCharts from "vue-apexcharts";
Vue.component("apexchart", VueApexCharts);
export default {
  data() {
    return {
      options: {
        chart: {
          type: "bar"
        }
      },
      legend: {
        position: "top"
      },
      series: []
    };
  },
  methods: {
    getIngresosMes() {
      let me = this;

      axios
        .get("/getIngresosMes")
        .then(function(response) {
          //optenemos los datos de respuesta en variable
          let datos = response.data;
          //el array series lo llenamos con los siguientes datos
          me.series = [
            {
              name: "Ingresos",
              data: datos //mandamos los datos que mostramos de respuesta
            }
          ];

          //console.log(datos);
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  },
  mounted() {
    this.getIngresosMes();
  }
};
</script>
