@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 mt-lg-5">
            <div class="card" style="background: rgba(76, 175, 80, 0.3)">
{{--                <div class="card-header">--}}
{{--                    <img src="{{ asset('img/logo.webp') }}" class="img-fluid rounded-circle" alt="logo" width="90" height="90">--}}
{{--                    {{ __('Login') }}--}}
{{--                </div>--}}

                <div class="card-body">
                    <div class="row justify-content-center mb-6">
                        <img src="{{ asset('img/logo.webp') }}" class="img-fluid rounded-circle mb-3" alt="logo" width="140" height="140">
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
{{--                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Username/Email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
{{--                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

{{--                        <div class="form-group row">--}}
{{--                            <div class="col-md-6 offset-md-4">--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

{{--                                    <label class="form-check-label" for="remember">--}}
{{--                                        {{ __('Remember Me') }}--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-2">
                                <button type="submit" class="btn btn-success form-control">
                                    {{ __('Login') }}
                                </button>

{{--                                @if (Route::has('password.request'))--}}
{{--                                    <a class="btn btn-link" href="{{ route('password.request') }}">--}}
{{--                                        {{ __('Forgot Your Password?') }}--}}
{{--                                    </a>--}}
{{--                                @endif--}}
                            </div>
                        </div>
                    </form>

                    <div class="copyright text-center mt-5">
                        <span>Copyright &copy; Basundhara Clinic and digonestic center All Right Reserve, 2021 || Developed by <a
                                href="https://www.facebook.com/SabbirHossain308/" target="_blank">Md Sabbir Hossain</a></span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
