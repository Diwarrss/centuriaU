@extends('adminCoreui.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card-group">
      <div class="card p-4">
        <div class="card-body">
            <form method="POST" action="{{ route('logingo') }}" autocomplete="off">
                @csrf
                <h1><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</h1>
                <p class="text-muted">Ingresa a tu cuenta</p>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="icon-user"></i>
                    </span>
                    </div>
                    <input id="email" type="email" placeholder="E-mail" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="icon-lock"></i>
                    </span>
                    </div>
                    <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-6">
                    <button class="btn btn-primary px-4" type="submit"><i class="fas fa-sign-in-alt"></i> Ingresar</button>
                    </div>
                    @if (Route::has('password.request'))
                        <div class="col-6 text-right">
                        <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                            ¿Has olvidado la contraseña?</a>
                        </div>
                    @endif
                </div>
            </form>
        </div>
      </div>
      <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
        <div class="card-body text-center">
          <div>
            <h2>Control Ingreso a Centuria</h2>
            <p>Software para llevar el control de las personas que ingresan al servicio de Centuria - UNISANGIL</p>
            <a class="btn btn-secondary active mt-3 disabled" href="/">Registrate!</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
