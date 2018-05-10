<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Quiz App - School Panel</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">
    @yield('css')

    <style>
        body {
            font-family: 'Lato';
        }

        .bg-light{background-color: #f8f9fa !important};

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">

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




    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    @yield('js')

</body>
</html>
