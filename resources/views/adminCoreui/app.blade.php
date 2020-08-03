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
    <title>Centuria Bases de Datos</title>
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
  <body class="app">
    <div class="container mt-5" id="app">
        {{-- se llama el contenido respectivamente a la Ruta --}}
        <main>
            @yield('content')
        </main>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{asset('/js/allCoreui.js')}}"></script>
    <script src="{{asset('/js/app.js')}}"></script>
  </body>
</html>
