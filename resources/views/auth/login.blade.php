<x-guest-layout>
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-navy">
          <div class="card-header text-center">
            <a href="/" class="h1"><b>ControlDoc</b></a>
          </div>
          <div class="card-body">
            <p class="login-box-msg">Inicia sessión</p>

            <x-jet-validation-errors class="" />

            @if (session('status'))
                <div class="alert alert-warning mb-3 rounded-0" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
              @csrf
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="email" value="{{old('email')}}" required autofocus>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fa-solid fa-envelope"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="password" class="form-control" name="password" required autocomplete="current-password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <div class="icheck-primary">
                    <input type="checkbox" id="remember_me" name="remember">
                    <label for="remember_me">
                        {{ __('Remember Me') }}
                    </label>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                </div>
                <!-- /.col -->
              </div>
            </form>

            <p class="mb-1">
              @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
              @endif
            </p>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.login-box -->
</x-guest-layout>
