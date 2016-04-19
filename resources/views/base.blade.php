<!DOCTYPE html>
<html lang="es">
    <head>
        @yield('head')
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Bootstrap -->
        {!! Html::style('assets/css/bootstrap.min.css') !!}

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <style type="text/css">

          .navbar-inverse {
            background-color: #454545;
            border-color: #e7e7e7;
          }
          .navbar-inverse .navbar-brand {
            color: #ffffff;
          }
          .navbar-inverse .navbar-brand:hover, .navbar-inverse .navbar-brand:focus {
            color: #a7a7a7;
          }
          .navbar-inverse .navbar-text {
            color: #ffffff;
          }
          .navbar-inverse .navbar-nav > li > a {
            color: #ffffff;
          }
          .navbar-inverse .navbar-nav > li > a:hover, .navbar-inverse .navbar-nav > li > a:focus {
            color: #a7a7a7;
          }
          .navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:focus {
            color: #a7a7a7;
            background-color: #e7e7e7;
          }
          .navbar-inverse .navbar-nav > .open > a, .navbar-inverse .navbar-nav > .open > a:hover, .navbar-inverse .navbar-nav > .open > a:focus {
            color: #a7a7a7;
            background-color: #e7e7e7;
          }
          .navbar-inverse .navbar-toggle {
            border-color: #e7e7e7;
          }
          .navbar-inverse .navbar-toggle:hover, .navbar-inverse .navbar-toggle:focus {
            background-color: #e7e7e7;
          }
          .navbar-inverse .navbar-toggle .icon-bar {
            background-color: #ffffff;
          }
          .navbar-inverse .navbar-collapse,
          .navbar-inverse .navbar-form {
            border-color: #ffffff;
          }
          .navbar-inverse .navbar-link {
            color: #ffffff;
          }
          .navbar-inverse .navbar-link:hover {
            color: #a7a7a7;
          }

          @media (max-width: 767px) {
            .navbar-inverse .navbar-nav .open .dropdown-menu > li > a {
              color: #ffffff;
            }
            .navbar-inverse .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-inverse .navbar-nav .open .dropdown-menu > li > a:focus {
              color: #a7a7a7;
            }
            .navbar-inverse .navbar-nav .open .dropdown-menu > .active > a, .navbar-inverse .navbar-nav .open .dropdown-menu > .active > a:hover, .navbar-inverse .navbar-nav .open .dropdown-menu > .active > a:focus {
              color: #a7a7a7;
              background-color: #e7e7e7;
            }
          }

          body {
            min-height: 250px;
            padding-top: 65px;
          }

        </style>

        <link rel="stylesheet" href="<?php echo url('/');?>/assets/css/dataTables.bootstrap.min.css" type="text/css"/>
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" >
    </head>

    <body>
        
    @section('navbar')

    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Fichajes UTN</a>

        </div>
        <div id="navbar" class="navbar-collapse collapse">
          
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">

              @if (Auth::guest())

              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Iniciar sesión <span class="caret"></span></a>
              <ul class="dropdown-menu">
               <fieldset>

                <div class="form-group">

                  <form class="form" role="form" method="POST" action="{{ url('/login') }}">

                    {!! csrf_field() !!}
                    
                    <div class="form-group">
                      <div class="col-lg-12">
                        <input type="text" class="form-control input-sm" id="name" name="username" placeholder="Usuario" required>
                      </div>
                    </div>

                    <div class="form-group" >
                      <div class="col-lg-12" style="margin-top: 5px;">
                        <input type="password" class="form-control input-sm" id="password" name="password" placeholder="Contraseña" required>
                      </div>
                    </div>

                    <div class="col-sm-12" align="center"  style="margin-top: 10px;">         
                      <button type="submit" class="btn btn-success btn-sm">Ingresar</button>
                    </div>

                  </form>

                </div>
              </fieldset>
              </ul>

              @else

                  <a class="navbar-brand" href="/backend">Backend</a>

                  <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                          {{ Auth::user()->name }} <span class="caret"></span>
                      </a>

                      <ul class="dropdown-menu" role="menu">
                          @if(Auth::user()->permisos == 1)
                              <li><a href="{{ url('/crear_usuario') }}"><i class="fa fa-btn fa-sign-out"></i>Crear Usuario</a></li>
                          @endif
                          <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Cerrar Sesión</a></li>
                      </ul>
                  </li>
              @endif

            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    @show

    {!! Html::script('assets/js/jquery-2.1.4.min.js') !!}
    {!! Html::script('assets/js/bootstrap.min.js') !!}

    {!! Html::script('assets/jquery-ui/jquery-ui.js') !!}

    {!! Html::script('assets/js/jquery.dataTables.min.js') !!}
    {!! Html::script('assets/js/dataTables.bootstrap.min.js') !!}
    {!! Html::script('assets/js/moment.min.js') !!}
    {!! Html::script('assets/js/datetime-moment.js') !!}
    
    {!! Html::script('assets/js/jquery.table2excel.js') !!}
 
    <script type="text/javascript">
      window.setTimeout(function() {
        $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
      }, 6000);

      window.setTimeout(function() {
        $(".alert-info").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
      }, 9000);

      window.setTimeout(function() {
        $(".alert-danger").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
      }, 6000);
    </script>

    @section('contenido')

    @show

    </body>

</html>
