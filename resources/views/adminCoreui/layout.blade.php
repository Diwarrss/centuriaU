<!DOCTYPE html>
<html lang="es">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Centuria">
    <meta name="keyword" content="Centuria">
    <!--Colocar icono del software en la barra del nombre de la pagina-->
    <link rel="icon" type="image/png" href="adminCoreui/img/brand/logoCenturia.png" />
    <title>Centuria Admin</title>
    <!-- Todos los JS del Coreui-->
    <link href="{{asset('/css/allCoreui.css') }}" rel="stylesheet">
    <!-- Global site tag (gtag.js) - Google Analytics-->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      // Shared ID
      gtag('config', 'UA-118965717-3');
      // Bootstrap ID
      gtag('config', 'UA-118965717-5');
    </script>
  </head>
  <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
      <div id="app">
        {{-- Barra Navegación Top Header --}}
        <navbarheader csrf="{{ csrf_token() }}"></navbarheader>
        <div class="app-body">
            {{-- Menu Lado Izquierdo --}}
            {{-- programado para mostrar dependiendo del rol --}}
                @auth
                    @if (Auth::user()->roles_id == 1)
                        <sidebardsuperadmin></sidebardsuperadmin>
                    @elseif (Auth::user()->roles_id == 2)
                        <sidebardadmin></sidebardadmin>
                    @elseif (Auth::user()->roles_id == 3)
                        <sidebardingreso></sidebardingreso>
                    @else
                        <sidebardconsulta></sidebardconsulta>
                    @endif
                @endauth
            {{-- CUERPO PRINCIPAL LLAMANDO CON VUE ROUTER--}}
                <router-view></router-view>
            {{-- MENU LADO DERECHO Componente--}}
                {{-- <sidebardright></sidebardright> --}}
        </div>
      </div>
        {{-- Footer del Admin --}}
        <footer class="app-footer">
            <div>
                <a href="http://www.unisangil.edu.co" target="_blanck">Departamento Sistemas y Tics</a>
                <span>2019 Copyright &copy; </span>
            </div>
            <div class="ml-auto">
                <span>Desarrollado por:</span>
                <a href="https://diego.gridsoft.co" target="_blanck">Ing. Diego Vargas</a>
            </div>
        </footer>
    <!-- CoreUI and necessary plugins-->
    <script src="{{asset('/js/allCoreui.js')}}"></script>
    <script src="{{asset('/js/app.js')}}"></script>
  </body>
</html>
