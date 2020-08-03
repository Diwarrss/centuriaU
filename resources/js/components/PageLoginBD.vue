<template>
  <!-- pagina para el sistema de login bases de datos http://centuria.unisangil.edu.co/bases-de-datos -->
  <div class="row justify-content-center main_login_bd">
    <div class="card col-md-5 col-12">
      <div class="card-header text-center">
        <img src="/storage/bases_datos.jpg" alt="" class="img-fluid">
        <!-- <h4><i class="fas fa-user-shield"></i> Control de acceso a Bases de Datos</h4> -->
      </div>
      <div class="card-body">
        <form @submit.prevent="loginBd">
          <div class="form-group">
            <strong><label for="exampleInputEmail1">Email Institucional</label></strong>
            <input v-model="email" type="email" :class="{'is-invalid' : errors.email}" class="form-control form-control-lg" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="emailx@unisangil.edu.co">
            <span
              class="help-block text-danger"
              v-if="errors.email"
              v-text="errors.email[0]"
            ></span>
            <!-- <small id="emailHelp" class="form-text text-muted">Ingresa tu E-mail universitario.</small> -->
          </div>
          <div class="form-group">
            <strong><label for="exampleInputPassword1">Número Documento</label></strong>
            <input v-model="documento" type="text" :class="{ 'is-invalid' : errors.documento}" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="1100XXXXXX">
            <span
              class="help-block text-danger"
              v-if="errors.documento"
              v-text="errors.documento[0]"
            ></span>
          </div>
          <div class="row justify-content-center">
            <button type="submit" class="btn btn-primary" :disabled="sendInfo">
              <div v-if="sendInfo">
                <div class="spinner-border spinner-border-sm text-light" role="status"></div> Ingresando
              </div>
              <div v-if="!sendInfo">
                <i class="fas fa-sign-in-alt"></i> Ingresar
              </div>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      documento: '',
      email: '',
      errors: {},
      data: {},
      sendInfo: false
    }
  },
  methods: {
    loginBd(){
      let me = this
      me.errors = {}
      me.sendInfo = true
      let urlApi = 'http://api.unisangil.edu.co/api/getUsuarios'
      axios.get(urlApi, {
        params: {
          type: 'BDCenturia',
          documento: me.documento,
          email: me.email
        }
      })
      .then(res => {
        //console.log(res)
        me.data = res.data;
        if (res.data.type === 'success') {
          //console.log('success')
          let arrayResult = res.data.data //obtenemos la respuesta de data
          let dataValid = arrayResult.find(ar => ar.estado === 'Activo' || ar.estado === 'ACTIVO') //buscamos si el estado es activo
          if (dataValid) {
            //save data in bd local
            axios.post('/createBdAccess', dataValid)
            .then(res => {
              if(res.data.type === 'success'){
                window.location.replace("http://centuria.unisangil.edu.co/bases-de-datos");
              }else{
                Swal.fire({
                  //toast: true,
                  position: "top",
                  type: "error",
                  title: "!Error en el Servidor, vuelve a intentar!",
                  showConfirmButton: false,
                  timer: 2500
                });
              }
              //console.log(res)
            })
            .catch(err => {
              Swal.fire({
                //toast: true,
                position: "top",
                type: "error",
                title: "!Error en el Servidor, vuelve a intentar!",
                showConfirmButton: false,
                timer: 2500
              });
              //console.error(err);
              me.sendInfo = false
            })
            //console.log(dataValid)
            me.sendInfo = false
          }else{
            Swal.fire({
              //toast: true,
              position: "top",
              type: "warning",
              title: "!Acceso no permitido!",
              showConfirmButton: false,
              timer: 2500
            });
            //console.log('Sin datos')
            me.sendInfo = false
          }
        }else{
          Swal.fire({
            //toast: true,
            position: "top",
            type: "warning",
            title: "!Acceso no permitido!",
            showConfirmButton: false,
            timer: 2500
          });
          me.sendInfo = false
        }
      })
      .catch(err => {
        if (err.response.status == 422) {
          //preguntamos si el error es 422
          me.errors = err.response.data.errors;
          me.sendInfo = false
        }
        /* Swal.fire({
          //toast: true,
          position: "top",
          type: "error",
          background: "#f6e1e1",
          title: "!Intenta de Nuevo!",
          showConfirmButton: false,
          timer: 2500
        }); */
        me.sendInfo = false
        //console.error(err);
      })
    }
  },
}
</script>
<style lang="scss">
  .main_login_bd{
    .card-header{
      padding: 0;
    }
  }
</style>
