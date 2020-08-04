{{-- pagina para el sistema de login bases de datos http://centuria.unisangil.edu.co/bases-de-datos --}}
@extends('adminCoreui.app')

@section('content')
  {{-- send url obtenida por url --}}
  <page-login-bd url="{{ $url }}"></page-login-bd>
@endsection
