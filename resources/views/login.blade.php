<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TimeCard</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <!-- Styles -->
    </head>
    <body>
        <div class="wrapper">
            <div class="login-container pc-only d-flex align-items-center justify-content-center">
                <div class="login-panel d-flex">
                    <div class="left-panel d-flex align-items-center justify-content-center">
                        <img src="{{ asset('/images/logo.png') }}" alt="logo" width="350">
                    </div>
                    <div class="right-panel">
                        <h4 class="login-title primary-text">Login</h4>
                        <form action="{{ route('login') }}" class="col-md-12 mt-5" method="post">
                            @csrf
                            <!-- @if ($error = $errors->first('password'))
                                <div class="alert alert-danger">
                                    {{ $error }}
                                </div>
                            @endif -->
                            <div class="d-flex mb-3">
                                <div class="col-md-3 primary-text text-right font-weight-bold"><label for="username">User Name:</label></div>
                                <input type="text" class="col-md-6 username custom-input" name="username">
                            </div>
                            <div class="d-flex mb-3">
                                <div class="col-md-3 primary-text text-right font-weight-bold"><label for="password">Password:</label></div>
                                <input type="password" class="col-md-6 password custom-input" name="password">
                            </div>
                            <div class="d-flex">
                                <button type="submit" class="col-md-6 text-uppercase text-white offset-md-3 custom-btn primary-bg p-1 font-weight-bold">login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="mobile-login-container primary-bg w-100 h-100 d-flex justify-content-center align-items-center">
                <div class="mobile-login w-100 p-2 m-2">
                    <div class="mobile-login-header p-2 primary-border-bottom">
                        <img src="{{ asset('images/logo_blue.png') }}" alt="logo" width="50%">
                    </div>
                    <form action="{{ route('login') }}" class="w-100 mt-4" method="post">
                        @csrf
                        <div class="d-flex mb-3">
                            <div class="col-4 pl-0 primary-text text-right font-weight-bold"><label for="username">User Name:</label></div>
                            <input type="text" class="col-7 username custom-input" name="username" id="username">
                        </div>
                        <div class="d-flex mb-3">
                            <div class="col-4 pl-0 primary-text text-right font-weight-bold"><label for="password">Password:</label></div>
                            <input type="password" class="col-7 password custom-input" name="password" id="password">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="text-uppercase text-white custom-btn p-1 font-weight-bold login-btn-mobile pl-3 pr-3">login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
