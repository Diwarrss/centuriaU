<template>
  <div>
    <div class="card card-accent-danger">
      <div class="card-header">
        <strong>
          <i class="far fa-list-alt"></i>
          Ingresos Totales ({{objectIngresos.total}})
        </strong>
        <div class="card-header-actions">
          <div class="form-group">
            <input class="form-control" v-model="search" type="text" placeholder="Buscar..." />
          </div>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-responsive-md table-hover table-sm">
          <thead>
            <tr>
              <th>Fecha Ingreso</th>
              <th>Documento</th>
              <th>Nombres y Apellidos</th>
              <th>Computador</th>
              <th>Préstamos</th>
            </tr>
          </thead>
          <tbody v-if="objectIngresos.data ==''">
            <td colspan="5">
              <div role="alert" class="alert alert-danger text-center">
                <div class="form-group">
                  <strong>
                    <h5>¡Sin información!</h5>
                  </strong>
                </div>
              </div>
            </td>
          </tbody>
          <!--
          <tbody v-for="data in objectIngresos.data" :key="data.id">
            <tr>
              <td>{{data.created_at | moment("DD/MM/YYYY h:mm:ss a")}}</td>
              <td>{{data.numero_documento}}</td>
              <td>{{data.nombre1}} {{data.nombre2}} {{data.apellido1}} {{data.apellido2}}</td>
              <td class="text-center">
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
              <td>
                <div v-if="!data.estado_prestamo">
                  <button
                    type="button"
                    data-toggle="modal"
                    data-target="#modalPrestamo"
                    class="btn btn-primary"
                    @click="modalPrestarEquipo(data.ingresosID)"
                  >
                    <i class="fas fa-laptop"></i> Prestar
                  </button>
                </div>
                <div v-else-if="data.estado_prestamo == 1">
                  <button
                    class="btn btn-secondary"
                    @click="recibirEquipo(data.computadorID, data.prestamoID)"
                  >
                    <i class="far fa-check-circle"></i> Recibido
                  </button>
                </div>
                <div v-else-if="data.estado_prestamo == 0">
                  <button class="btn btn-success" disabled>
                    <i class="far fa-check-circle"></i> Ya Recibido
                  </button>
                </div>
              </td>
            </tr>
          </tbody>-->
        </table>
      </div>
    </div>
  </div>
</template>
<script>
//importamos para usar el mapState, mapActions
import { mapState, mapActions } from "vuex";
export default {
  data() {
    return {
      search: "",
      objectIngresos: {},
      pagActual: ""
    };
  },
  computed: {
    ...mapState(["infoUserAuth", "infoPeriodo"])
  },
  methods: {
    ...mapActions(["getUserAuth", "getPeriodo"]),
    getIngresos(page, buscar) {
      let me = this;
      //enviamos los criterios para la paginacion y igualmente el parametro buscar a la ruta, controlador pagina por la busqueda
      axios
        .get("getIngresos?page=" + page + "&buscar=" + me.buscar)
        .then(response => {
          me.objectIngresos = response.data;
          me.pagActual = response.data.current_page; //capturamos el id de la pagina actual mostrando
        });
    }
  },
  mounted() {
    this.getPeriodo();
    this.getUserAuth();
    this.getIngresos();
  }
};
</script>
