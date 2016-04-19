@extends('base')

@section('title','Crear Usuario')

@section('navbar')

	@parent

@stop

@section('contenido')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Crear un nuevo usuario</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register_user') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Nombre completo</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Ingrese nombre y apellido." required>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Nombre de usuario</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Ingrese nombre de usuario." required>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        @if($errors->first('username') == 'The username has already been taken.')
                                            <strong>El nombre de usuario introducido no se encuentra disponible.</strong>
                                        @else
                                            <strong>{{ $errors->first('username') }}</strong>
                                        @endif
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail</label>
                            
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Ingrese su correo electrónico.">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        @if($errors->first('email') == 'The email has already been taken.')
                                            <strong>Ya existe un usuario con ese email.</strong>
                                        @else
                                            <strong>{{ $errors->first('email') }}</strong>
                                        @endif
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Contraseña</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password" placeholder="Ingrese su contraseña." required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        @if($errors->first('password') == 'The password confirmation does not match.')
                                            <strong>Las contraseñas no coinciden.</strong>
                                        @else
                                            <strong>{{ $errors->first('password') }}</strong>
                                        @endif
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Confirmar Contraseña</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Vuelva a ingresar su contraseña." required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <a href="/backend" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>&nbsp;Volver</a>
                                <button type="submit" class="btn btn-success pull-right">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Crear
                                </button>
                            </div>
                        </div>
                        <div style="padding: 10px;">
                            @if (session('status4'))
                                @if (session('codigo') == '1')
                                    <div id='mensaje' class="alert alert-success">
                                    {{ session('status4') }}
                                    </div>
                                @elseif (session('codigo') == '2')
                                    <div id='mensaje' class="alert alert-info">
                                    {{ session('status4') }}
                                    </div>
                                @else
                                    <div id='mensaje' class="alert alert-danger">
                                    {{ session('status4') }}
                                    </div>
                                @endif
                                
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop