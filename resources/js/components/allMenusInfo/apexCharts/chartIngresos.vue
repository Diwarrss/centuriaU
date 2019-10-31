<template>
  <div class="card">
    <div class="card-header">
      <h5>
        <strong>
          <i class="fas fa-chart-bar"></i>
          Ingresos/Rol Persona
        </strong>
      </h5>
    </div>
    <div class="card-body">
      <div v-if="series.length > 0">
        <div class="col-md-12">
          <form class="form-inline">
            <label class="my-2 mr-3">
              <i class="fas fa-calendar-day"></i> Fecha:
            </label>
            <datetime
              v-model="fecha"
              format="yyyy-MM-dd"
              @input="getDatos(fecha)"
              value-zone="America/Bogota"
            ></datetime>
          </form>
        </div>
        <apexchart width="100%" height="auto" :options="options" :series="series"></apexchart>
      </div>
    </div>
  </div>
</template>
<script>
//import vue charts desde apexcharts completo
import VueApexCharts from "vue-apexcharts";
Vue.component("apexchart", VueApexCharts);

import moment from "moment";
moment.locale("es");
export default {
  data() {
    return {
      fecha: "",
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
    getDatos(fecha) {
      let me = this;
      //capturamos fecha actual
      let fechaActual = moment();
      //se convierte al fecha en el formato q se necesita pero validamos si hay parametro o no
      if (fecha) {
        me.fecha = moment(String(fecha)).format("YYYY-MM-DD");
      } else {
        me.fecha = moment(String(fechaActual)).format("YYYY-MM-DD");
      }

      axios
        .get("/getIngresoTipoPersona", {
          params: { fecha: me.fecha }
        })
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
    this.getDatos(this.fecha);
  }
};
</script>
