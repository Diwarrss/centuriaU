<!DOCTYPE html>
<html lang="es">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Gridsoft">
    <meta name="keyword" content="Gridsoft">
    <title>Gridsoft Admin</title>
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
                <sidebardleft></sidebardleft>
            {{-- CUERPO PRINCIPAL LLAMANDO CON VUE ROUTER--}}
                <router-view></router-view>
            {{-- MENU LADO DERECHO Componente--}}
                <sidebardright></sidebardright>
        </div>
      </div>
        {{-- Footer del Admin --}}
        <footer class="app-footer">
            <div>
                <a href="https://www.gridsoft.co/">GridSoft</a>
                <span>&copy; 2019 creativeLabs.</span>
            </div>
            <div class="ml-auto">
                <span>Powered by</span>
                <a href="https://www.gridsoft.co/">GridSoft</a>
            </div>
        </footer>
    <!-- CoreUI and necessary plugins-->
    <script src="{{asset('/js/allCoreui.js')}}"></script>
    <script src="{{asset('/js/app.js')}}"></script>
  </body>
</html>
