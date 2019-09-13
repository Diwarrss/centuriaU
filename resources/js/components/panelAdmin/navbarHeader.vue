<template>
  <header class="app-header navbar">
    <button
      class="navbar-toggler sidebar-toggler d-lg-none mr-auto"
      type="button"
      data-toggle="sidebar-show"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="/admin">
      <img
        class="navbar-brand-full"
        src="adminCoreui/img/brand/logo.svg"
        width="89"
        height="25"
        alt="CoreUI Logo"
      />
      <img
        class="navbar-brand-minimized"
        src="adminCoreui/img/brand/sygnet.svg"
        width="30"
        height="30"
        alt="CoreUI Logo"
      />
    </a>
    <button
      class="navbar-toggler sidebar-toggler d-md-down-none"
      type="button"
      data-toggle="sidebar-lg-show"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav navbar-nav d-md-down-none">
      <li class="nav-item px-3">
        <router-link class="nav-link" to="/">
          <i class="nav-icon icon-speedometer"></i> Escritorio
        </router-link>
      </li>
      <li class="nav-item px-3">
        <router-link class="nav-link" to="/usuarios">
          <i class="fas fa-users-cog"></i> Usuarios
        </router-link>
      </li>
      <li class="nav-item px-3">
        <router-link class="nav-link" to="/usuarios">
          <i class="fas fa-wrench"></i> Configuración
        </router-link>
      </li>
    </ul>
    <ul class="nav navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a
          class="nav-link"
          data-toggle="dropdown"
          href="#"
          role="button"
          aria-haspopup="true"
          aria-expanded="false"
        >
          <a class="d-md-down-none">Administrador</a>
          <img
            class="img-avatar"
            src="adminCoreui/img/avatars/6.jpg"
            alt="admin@bootstrapmaster.com"
          />
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <div class="dropdown-header text-center">
            <strong>Cuenta</strong>
          </div>
          <router-link class="dropdown-item" to="/perfil">
            <i class="fa fa-user"></i> Perfil
          </router-link>
          <router-link class="dropdown-item" to="/config">
            <i class="fa fa-wrench"></i> Configuración
          </router-link>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="/logout" @click="logout()">
            <i class="fas fa-sign-out-alt text-danger"></i> Cerrar Sesión
          </a>
          <form id="logout-form" action="/logout" method="POST" style="display: none;">
            <input type="hidden" name="_token" v-bind:value="csrf" />
          </form>
        </div>
      </li>
    </ul>
    <button
      class="navbar-toggler aside-menu-toggler d-md-down-none"
      type="button"
      data-toggle="aside-menu-lg-show"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <button
      class="navbar-toggler aside-menu-toggler d-lg-none"
      type="button"
      data-toggle="aside-menu-show"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
  </header>
</template>
<script>
export default {
  props: ["csrf"],
  methods: {
    logout() {
      event.preventDefault();
      document.getElementById("logout-form").submit();
    }
  }
};
</script>
