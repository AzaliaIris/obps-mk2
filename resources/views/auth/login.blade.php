<!DOCTYPE html>
<html lang="en">
<head>
  @include('admin.css')
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f8f9fa;
    }
    .login-container {
      width: 100%;
      max-width: 400px;
      padding: 15px;
      background: white;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .login-container .title {
      text-align: center;
      margin-bottom: 20px;
    }
    .brand-text {
        font-size: 24px; /* Sesuaikan ukuran font sesuai kebutuhan */
        text-align: center;
        margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="brand-text brand-big visible text-uppercase"><strong class="text-primary">Office</strong><strong>BPS</strong></div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <!-- Username -->
      <div class="form-group">
        <label for="username">{{ __('Username') }}</label>
        <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus autocomplete="username">
        <x-input-error :messages="$errors->get('username')" class="mt-2" />
      </div>

      <!-- Password -->
      <div class="form-group">
        <label for="password">{{ __('Password') }}</label>
        <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
      </div>

      <!-- Remember Me -->
      <div class="form-group form-check">
        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
        <label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block">{{ __('Log in') }}</button>
      </div>
    </form>
  </div>

  <!-- JavaScript files-->
  <script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"></script>
  <script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"></script>
  <script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
  <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
  <script src="{{asset('admincss/js/charts-home.js')}}"></script>
  <script src="{{asset('admincss/js/front.js')}}"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//cdn.datatables.net/2.1.0/js/dataTables.min.js"></script>
</body>
</html>
