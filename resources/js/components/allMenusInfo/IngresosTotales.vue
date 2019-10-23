<template>
  <div>
    <div class="card card-accent-danger">
      <div class="card-header">
        <h5>
          <strong>
            <i class="far fa-list-alt"></i>
            Ingresos Totales ({{objectIngresos.total}})
          </strong>
        </h5>
      </div>
      <div class="card-body">
        <div class="col-md-4">
          <div class="form-group">
            <div class="input-group">
              <!-- keydown para ejecutar cuando vayan escribiendo -->
              <input
                type="text"
                placeholder="Texto..."
                v-model="buscar"
                class="form-control"
                @keydown="getIngresos(1,buscar)"
                @keyup.enter="getIngresos(1,buscar)"
              />
              <span class="input-group-append">
                <button type="button" class="btn btn-primary" @click="getIngresos(1,buscar)">
                  <i class="fas fa-search"></i> Buscar
                </button>
              </span>
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
              <th>Computador</th>
              <th>Préstamos</th>
            </tr>
          </thead>
          <tbody v-if="objectIngresos.data ==''">
            <td colspan="6">
              <div role="alert" class="alert alert-danger text-center">
                <div class="form-group">
                  <strong>
                    <h5>¡Sin información!</h5>
                  </strong>
                </div>
              </div>
            </td>
          </tbody>
          <tbody v-for="data in objectIngresos.data" :key="data.ingresosID">
            <tr>
              <td v-text="data.ingresosID"></td>
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
</template>
<script>
//importamos para usar el mapState, mapActions
import { mapState, mapActions } from "vuex";
export default {
  data() {
    return {
      buscar: "",
      objectIngresos: {},
      pagActual: "",
      arrayCompuLibres: [],
      arrayErrors: [],
      ingresosID: "",
      computadores_id: ""
    };
  },
  computed: {
    ...mapState(["infoUserAuth"])
  },
  methods: {
    ...mapActions(["getUserAuth"]),
    getIngresos(page, buscar) {
      let me = this;
      //enviamos los criterios para la paginacion y igualmente el parametro buscar a la ruta, controlador pagina por la busqueda
      axios
        .get("getIngresos?page=" + page + "&buscar=" + me.buscar)
        .then(response => {
          me.objectIngresos = response.data;
          me.pagActual = response.data.current_page; //capturamos el id de la pagina actual mostrando
        });
    },
    modalPrestarEquipo(ingresosID) {
      let me = this;
      me.getComputadorlibre();
      //capturo el id del ingreso
      me.ingresosID = ingresosID;
    },
    crearPrestamo() {
      let me = this;
      axios
        .post("/crearPrestamo", {
          ingresosID: me.ingresosID,
          estado_prestamo: 1,
          users_id: me.infoUserAuth[0].id,
          sedes_id: me.infoUserAuth[0].sedes_id,
          computadores_id: me.computadores_id
        })
        .then(function(response) {
          me.cerrarModalPrestamo();
          me.getIngresosActuales();
          Swal.fire({
            position: "top-end",
            type: "success",
            title: "Prestamó creado con éxito",
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
    cerrarModalPrestamo() {
      let me = this;
      me.arrayErrors = [];
      //cerrar modal prestamo
      $("#modalPrestamo").modal("hide");
      //limpio las variables del prestamo
      me.ingresosID = "";
      me.computadores_id = "";
    },
    recibirEquipo(computadorID, prestamoID) {
      let me = this;
      Swal.fire({
        title: "¿Computador recibido?",
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "green",
        cancelButtonColor: "red",
        confirmButtonText: '<i class="fas fa-check"></i> Si',
        cancelButtonText: '<i class="fas fa-times"></i> No'
      }).then(result => {
        if (result.value) {
          // /recibir Equipo y marcar prestamo finalizado
          axios
            .post("/finalizarPrestamo", {
              computadorID: computadorID,
              prestamoID: prestamoID
            })
            .then(function(response) {
              me.getIngresosActuales();
              Swal.fire({
                toast: true,
                position: "top-end",
                type: "success",
                title: "Equipo disponible!",
                showConfirmButton: false,
                timer: 1500
              });
            })
            .catch(function(error) {
              if (error.response.status == 422) {
                //preguntamos si el error es 422
                Swal.fire({
                  toast: true,
                  position: "top-end",
                  type: "error",
                  title: "Se produjo un Error, Reintentar",
                  showConfirmButton: false,
                  timer: 2500
                });
              }
              //console.log(error.response.data.errors);
            });
        }
      });
    },
    getComputadorlibre() {
      let me = this;
      axios
        .get("/getComputadorlibre")
        .then(function(response) {
          // handle success
          me.arrayCompuLibres = response.data;
          //console.log(response);
        })
        .catch(function(error) {
          // handle error
          //console.log(error);
        });
    }
  },
  mounted() {
    this.getUserAuth();
    this.getIngresos(this.pagActual, "");
  }
};
</script>
