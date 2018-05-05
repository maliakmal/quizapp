<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Quizly') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <hr/>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-4">
                    <p>About</p>
                    <p>Contact Us</p>
                    <p>Terms and Conditions</p>
                </div>
                <div class="col-4">
                    <p><i class="fab fa-facebook"></i> &nbsp;Facebook</p>
                    <p><i class="fab fa-twitter" ></i>  &nbsp;Twitter</p>
                    <p><i class="fab fa-instagram" ></i>  &nbsp;Instagram</p>
                </div>
                <div class="col-4 text-right">
                    <ddress>
                    Jumairah Lake Towers<br/>
                    Dubai, U.A.E<br/>
                    +971 445  678 903<br/>
                    <a href="mailto:info@mail.com">info@mail.com</a>
                </ddress>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
