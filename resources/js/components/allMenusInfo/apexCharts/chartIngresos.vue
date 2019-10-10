<template>
  <div>
    <apexchart width="100%" height="auto" type="bar" :options="options" :series="series"></apexchart>
  </div>
</template>
<script>
//import vue charts desde apexcharts completo
import VueApexCharts from "vue-apexcharts";
Vue.component("apexchart", VueApexCharts);
export default {
  data() {
    return {
      options: {},
      series: []
    };
  },
  methods: {
    getDatos() {
      let me = this;

      axios
        .get("/getIngresoPrograma")
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
    this.getDatos();
  }
};
</script>
