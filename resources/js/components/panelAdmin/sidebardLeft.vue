<template>
  <div class="sidebar">
    <nav class="sidebar-nav">
      <ul class="nav">
        <li class="nav-item">
          <router-link class="nav-link" to="/">
            <i class="nav-icon icon-speedometer"></i> Escritorio
            <span class="badge badge-primary">Ver</span>
          </router-link>
        </li>
        <li class="nav-title text-center">
          <i class="nav-icon icon-home"></i> Menú
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/ingresos">
            <i class="nav-icon icon-user-following"></i> Ingresos
          </router-link>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="typography.html">
            <i class="nav-icon icon-pencil"></i> Typography
          </a>
        </li>
        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="nav-icon icon-puzzle"></i> Base
          </a>
          <ul class="nav-dropdown-items">
            <li class="nav-item">
              <a class="nav-link" href="base/breadcrumb.html">
                <i class="nav-icon icon-puzzle"></i> Breadcrumb
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="base/cards.html">
                <i class="nav-icon icon-puzzle"></i> Cards
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-title text-center">
          <i class="nav-icon icon-equalizer"></i> Herramientas
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/perfil">
            <i class="nav-icon icon-user"></i> Perfil
          </router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/config">
            <i class="nav-icon icon-wrench"></i> Configuración
          </router-link>
        </li>
        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="nav-icon icon-cursor"></i> Buttons
          </a>
          <ul class="nav-dropdown-items">
            <li class="nav-item">
              <a class="nav-link" href="buttons/buttons.html">
                <i class="nav-icon icon-cursor"></i> Buttons
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="buttons/button-group.html">
                <i class="nav-icon icon-cursor"></i> Buttons Group
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="buttons/dropdowns.html">
                <i class="nav-icon icon-cursor"></i> Dropdowns
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="buttons/brand-buttons.html">
                <i class="nav-icon icon-cursor"></i> Brand Buttons
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="charts.html">
            <i class="nav-icon icon-pie-chart"></i> Charts
          </a>
        </li>
      </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
  </div>
</template>
<script>
export default {
  data() {
    return {};
  }
};
</script>
<style scoped>
/* colocar estilo al router-link-active */
.router-link-exact-active {
  background: black;
}
</style>
