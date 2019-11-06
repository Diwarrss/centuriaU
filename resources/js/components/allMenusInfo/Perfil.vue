<template>
  <main class="main" v-if="infoUserAuth.length">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="nav-icon icon-user"></i> Perfil
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
    <div class="container-fluid" v-if="infoUserAuth.length && arrayUsuario.length">
      <div class="ui-view">
        <div>
          <div class="animated fadeIn">
            <div class="row" v-for="(data, index) in arrayUsuario" :key="index">
              <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                <div class="card card-accent-info" v-if="habilitarEditar == 0">
                  <div class="card-header">
                    <h5>
                      <strong>
                        <i class="fas fa-user-cog"></i>
                        Mi Perfil
                      </strong>
                    </h5>
                  </div>
                  <div class="card-body">
                    <div class="form-group row">
                      <div class="col-md-3 col-xl-4">
                        <label for="universidad">Nombre:</label>
                      </div>
                      <div class="col-md-9 col-xl-8">
                        <input
                          class="form-control"
                          type="text"
                          id="universidad"
                          readonly
                          v-model="data.name"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-3 col-xl-4">
                        <label for="email">E-Mail:</label>
                      </div>
                      <div class="col-md-9 col-xl-8">
                        <input
                          class="form-control"
                          id="email"
                          type="text"
                          v-model="data.email"
                          readonly
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-3 col-xl-4">
                        <label for="estado">Estado:</label>
                      </div>
                      <div class="col-md-9 col-xl-8">
                        <input
                          v-if="data.estado_user == 1"
                          class="form-control is-valid"
                          id="estado"
                          type="text"
                          value="Activo"
                          readonly
                        />
                        <input
                          v-else
                          class="form-control is-invalid"
                          id="estado"
                          type="text"
                          value="Inactivo"
                          readonly
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-3 col-xl-4">
                        <label for="rol">Rol:</label>
                      </div>
                      <div class="col-md-9 col-xl-8">
                        <input
                          class="form-control"
                          id="rol"
                          type="text"
                          v-model="data.nombreRol"
                          readonly
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-3 col-xl-4">
                        <label for="sede">Sede:</label>
                      </div>
                      <div class="col-md-9 col-xl-8">
                        <input
                          class="form-control"
                          id="sede"
                          type="text"
                          v-model="data.nombreSede"
                          readonly
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-3 col-xl-4">
                        <label for="actualizado">Última Actualización:</label>
                      </div>
                      <div class="col-md-9 col-xl-8">
                        <input
                          class="form-control"
                          id="actualizado"
                          type="text"
                          v-model="data.actualizado"
                          readonly
                        />
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <button class="btn btn-success" @click="editarPerfil">
                      <i class="fas fa-edit"></i> Editar
                    </button>
                  </div>
                </div>
                <div class="card card-accent-info" v-else>
                  <div class="card-header">
                    <h5>
                      <strong>
                        <i class="fas fa-user-cog"></i>
                        Mi Perfil
                      </strong>
                    </h5>
                  </div>
                  <div class="card-body">
                    <div class="form-group row">
                      <div class="col-md-3 col-xl-4">
                        <label for="nombre">Nombre:</label>
                      </div>
                      <div class="col-md-9 col-xl-8">
                        <input class="form-control" type="text" id="nombre" v-model="nombre" />
                        <span
                          class="help-block text-danger"
                          v-if="arrayErrors.nombre"
                          v-text="arrayErrors.nombre[0]"
                        ></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-3 col-xl-4">
                        <label for="email">E-Mail:</label>
                      </div>
                      <div class="col-md-9 col-xl-8">
                        <input class="form-control" id="email" type="text" v-model="email" />
                        <span
                          class="help-block text-danger"
                          v-if="arrayErrors.email"
                          v-text="arrayErrors.email[0]"
                        ></span>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <button class="btn btn-success" @click="updatePerfil">
                      <i class="fas fa-upload"></i> Actualizar
                    </button>
                    <button class="btn btn-danger" @click="cancelarUpdate">
                      <i class="fas fa-close"></i> Cancelar
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                <div class="card card-accent-info">
                  <div class="card-header">
                    <h5>
                      <strong>
                        <i class="far fa-images"></i>
                        Mi Foto
                      </strong>
                    </h5>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <img
                        :src="data.url_imagen"
                        class="rounded mx-auto d-block img-fluid"
                        width="100"
                      />
                    </div>
                    <div class="form-group">
                      <div class="custom-file">
                        <input
                          type="file"
                          class="custom-file-input"
                          name="imagen"
                          id="imagen"
                          @change="obtenerImagen"
                        />
                        <label
                          class="custom-file-label"
                          for="file"
                          v-if="!imagenEnviar"
                        >Elegir Imagen</label>
                        <label class="custom-file-label" for="file" v-else>{{imagenEnviar.name}}</label>
                        <span
                          class="help-block text-danger"
                          v-if="arrayErrors.imagen"
                          v-text="arrayErrors.imagen[0]"
                        ></span>
                      </div>
                    </div>
                    <img class="rounded mx-auto d-block img-fluid" width="100" :src="cambioImagen" />
                    <div class="form-group align-content-center" v-if="imagenEnviar">
                      <button class="btn btn-success" @click="enviarImagen(data)">
                        <i class="fas fa-upload"></i> Actualizar
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                <div class="card card-accent-success">
                  <div class="card-header">
                    <h5>
                      <strong>
                        <i class="fas fa-key"></i>
                        Cambiar Contraseña
                      </strong>
                    </h5>
                  </div>
                  <div class="card-body">
                    <div class="form-group row">
                      <div class="col-md-3 col-xl-4">
                        <label for="pass1">Nueva Contraseña:</label>
                      </div>
                      <div class="col-md-9 col-xl-8">
                        <input class="form-control" type="password" id="pass1" v-model="password" />
                        <span
                          class="help-block text-danger"
                          v-if="arrayErrors.password"
                          v-text="arrayErrors.password[0]"
                        ></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-3 col-xl-4">
                        <label for="pass2">Confirmación:</label>
                      </div>
                      <div class="col-md-9 col-xl-8">
                        <input class="form-control" id="pass2" type="password" v-model="passwordV" />
                        <span
                          class="help-block text-danger"
                          v-if="password != passwordV"
                        >Contraseñas no Coinciden</span>
                        <span
                          class="help-block text-danger"
                          v-if="arrayErrors.passwordV"
                          v-text="arrayErrors.passwordV[0]"
                        ></span>
                      </div>
                    </div>
                    <div class="form-group align-content-center" v-if="password === passwordV">
                      <button class="btn btn-success" @click="updatePass">
                        <i class="fas fa-upload"></i> Actualizar
                      </button>
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
      arrayErrors: [],
      arrayUsuario: [],
      habilitarEditar: 0,
      imagenAnterior: "",
      idUser: "",
      nombre: "",
      email: "",
      imagenMiniatura: "",
      imagenEnviar: "",
      password: "",
      passwordV: ""
    };
  },
  computed: {
    ...mapState(["infoUserAuth"]),
    cambioImagen() {
      return this.imagenMiniatura;
    }
  },
  methods: {
    ...mapActions(["getUserAuth"]),
    getPerfil() {
      let me = this;
      axios
        .get("/getPerfil")
        .then(function(response) {
          me.arrayUsuario = response.data;
          me.imagenAnterior = response.data[0].url_imagen;
          me.idUser = response.data[0].id;
          //console.log(response);
        })
        .catch(function(error) {
          // handle error
          //console.log(error);
        });
    },
    editarPerfil() {
      let me = this;
      me.nombre = me.arrayUsuario[0].name;
      me.email = me.arrayUsuario[0].email;
      me.habilitarEditar = 1;
    },
    updatePerfil() {
      let me = this;
      axios
        .post("/updatePerfil", {
          id: me.idUser,
          nombre: me.nombre,
          email: me.email
        }) //le envio el parametro completo
        .then(function(response) {
          me.getPerfil();
          me.arrayErrors = [];
          me.habilitarEditar = 0;
          //si es exitoso mostramos el resultado enviado desde el server
          Swal.fire({
            position: "top",
            type: "success",
            title: "Perfil actualizado con éxito",
            showConfirmButton: false,
            timer: 1500
          });
          //console.log(response.data);
        })
        .catch(function(error) {
          if (error.response.status == 422) {
            //preguntamos si el error es 422
            me.arrayErrors = error.response.data.errors; //guardamos la respuesta del server de errores en el array arrayErrors
          }
        });
    },
    cancelarUpdate() {
      let me = this;
      me.getPerfil();
      me.habilitarEditar = 0;
      me.arrayErrors = [];
    },
    obtenerImagen(e) {
      let me = this;
      let file = event.target.files[0];

      me.imagenEnviar = file; //guardamos el archivo en esta variable
      me.cargarImagen(file);
      //console.log(me.imagenEnviar);
    },
    cargarImagen(file) {
      let me = this;
      let reader = new FileReader(); //manejar archivos
      //la e hace referencia a file
      reader.onload = e => {
        me.imagenMiniatura = e.target.result;
      };
      reader.readAsDataURL(file); //url de imagen cargada
    },
    enviarImagen(data) {
      let me = this;
      let formData = new FormData();
      formData.append("id", data["id"]);
      formData.append("imagenAnterior", me.imagenAnterior);
      formData.append("imagen", me.imagenEnviar);

      //le enviamos formdata q lleva toda la data
      axios
        .post("/updateAvatar", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        }) //le envio el parametro completo
        .then(function(response) {
          me.imagenMiniatura = "";
          me.imagenEnviar = "";

          me.getPerfil();
          //si es exitoso mostramos el resultado enviado desde el server
          Swal.fire({
            position: "top",
            type: "success",
            title: "Avatar actualizado con éxito",
            showConfirmButton: false,
            timer: 1500
          });
          //console.log(response.data);
        })
        .catch(function(error) {
          if (error.response.status == 422) {
            //preguntamos si el error es 422
            me.arrayErrors = error.response.data.errors; //guardamos la respuesta del server de errores en el array arrayErrors
          }
        });
    },
    updatePass() {
      let me = this;

      axios
        .post("/updatePass", {
          id: me.idUser,
          password: me.password,
          passwordV: me.passwordV
        }) //le envio el parametro completo
        .then(function(response) {
          me.arrayErrors = [];
          me.password = "";
          me.passwordV = "";
          //si es exitoso mostramos el resultado enviado desde el server
          Swal.fire({
            position: "top",
            type: "success",
            title: "Contraseña actualizada con éxito",
            showConfirmButton: false,
            timer: 1500
          });
          //console.log(response.data);
        })
        .catch(function(error) {
          if (error.response.status == 422) {
            //preguntamos si el error es 422
            me.arrayErrors = error.response.data.errors; //guardamos la respuesta del server de errores en el array arrayErrors
          }
        });
    }
  },
  mounted() {
    this.getUserAuth();
    this.getPerfil();
  }
};
</script>
