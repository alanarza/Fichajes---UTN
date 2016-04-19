@extends('base')

@section('head')
    <meta http-equiv="refresh" content="1800">
@stop

@section('title', 'Fichajes - UTN')

@section('navbar')

	@parent

@stop

@section('contenido')
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" style="text-align: center;">Información</h4>
      </div>
      <div class="modal-body">
        <h3 style="text-align: center;">Sistema de fichajes de SCTeIP</h3>
        <br>
        Este sistema fue ideado por la <b>Secretaría de Ciencia, 
        Tecnología e Innovación Productiva de Chubut</b> para registrar la entrada y salida de sus empleados.<br>
        Ésta versión es una <b>adaptación</b> para la <b>Universidad Tecnológica Nacional de Puerto Madryn</b> y sus necesidades.<br><br>

        <b>Funcionamiento:<br><br>
        Entrada: </b>para registrar el horario de entrada, basta con ingresar el documento en el formulario (sin puntos), pulsar "Entrar" (o Enter)
        y el programa automáticamente registrará fecha, hora y ID de empleado. <br><br>
        <b>Salida: </b> El procedimiento es el mismo que el registro de horario de entrada.<br><br>
        <b>Cabe recalcar que se pueden registrar varias entradas y salidas en un mismo día.</b>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-lg center-block" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12" >
        @if(count($registros) > 1)
            @if($registros[0]->entrada != NULL && $registros[0]->entrada == $registros[1]->entrada)
                <div class="alert alert-warning">
                    <strong>¡AVISO!</strong> Debido a algún inconveniente no fue posible registrar las entradas de hoy. Se han cargado entradas para todo el personal con llegada a las 08:00. Ya pueden registrar su salida.
                </div>
            @endif
        @endif
    	<div class="panel panel-default">
		  <div class="panel-heading"><h1 class="panel-title pull-left">Sistema de fichajes - UTN</h1>
	        <button class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> &nbsp;Info</button>
	        <div class="clearfix"></div>
		  </div>
		  <div class="panel-body">

		  	<div class="container">
	            @if (count($errors) > 0)
	        		<div class="alert alert-warning" role="alert">
	      				<ul>
	              			<strong>Oops! Something went wrong : </strong>
	          				@foreach ($errors->all() as $error)
	        				<li>{{ $error }}</li>
	                		@endforeach
	            		</ul>
	        		</div>
	    		@endif
			</div>
			  
		  	<div class="col-md-4">
		  		<div class="panel panel-default">
				  	<div class="panel-body">
				    
					  	<fieldset>

			                <div class="form-group">

			                  	<form id="myform" action="{{ url("fichaje") }}" method="post">

			                    {!! csrf_field() !!}
			                    
			                    	<div class="input-group input-group-lg">
								  		<span class="input-group-addon" id="sizing-addon1">DNI</span>
								  		<input id="dni" type="text" class="form-control" placeholder="Ingrese su documento." aria-describedby="sizing-addon1" name="dni" pattern="^(\d{6,10})$" autofocus required="true">
									</div>

									<br>

				              		<button type="submit" class="btn btn-default btn-lg pull-right"><span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span>&nbsp; Fichar </button>
								
			                 	</form>

			                </div>

	              		</fieldset>

			  		</div>

			  		<div style="padding: 10px;">
					  	@if (session('status'))
					  		@if (session('codigo') == '1')
						    	<div id='mensaje' class="alert alert-success">
						    	{{ session('status') }}
						    	</div>
						   	@elseif (session('codigo') == '2')
						   		<div id='mensaje' class="alert alert-info">
						        {{ session('status') }}
						        </div>
						    @else
						    	<div id='mensaje' class="alert alert-danger">
						    	{{ session('status') }}
						    	</div>
						   	@endif
						    
						@endif
					</div>


			  	</div>

			  	<div class="center-block" style="text-align:center;width:350px;padding:0.5em 0;"> <h2><a style="text-decoration:none;" href=""><span style="color:black;">Hora actual en</span> Pto. Madryn</a><br><span style="color:black;">{{ $dt }}</span></h2></div>
			  	<canvas class="center-block"></canvas>


		    </div>

			  <div class="col-md-8" >
			  		<div class="panel panel-default">
					  <div class="panel-body">
					    <table id="registros" class="table table-striped table-hover">
						  <thead>
						    <tr>
						      <th class="no-sort">#</th>
						      <th>Nombre</th>
						      <th>Entrada</th>
						      <th>Salida</th>
						    </tr>
						  </thead>
						  <tbody>
						  	@foreach($registros as $key => $registro)
                                @if (session('codigo') == 1)
							        <tr id="{{ $key+1 }}">
                                @else
                                    <tr>
                                @endif
							      <td>{{ $key+1 }}</td>
							      <td>{{ $registro->personal->persona->nombre }}</td>
							      @if($registro->entrada == NULL)
							      	<td>No se registró entrada</td>
							      @else
							      	<td>{{ $registro->entrada }}</td>
							      @endif
							      @if($registro->salida == NULL)
							      	<td>No se registró salida</td>
							      @else
							      	<td>{{ $registro->salida }}</td>
							      @endif
							    </tr>
							@endforeach
						  </tbody>
						</table> 
					  </div>
					</div>
			  	</div> 
		</div>
  	</div>
    
</div>
</div>
<footer>
    
<div class="copyright">
    <p style="text-align: center; vertical-align: middle;">
        <img class="pull-left" src="{{ asset('logo_utn.png') }}">
        <img class="pull-right" style="padding-bottom: 12px;" src="{{ asset('logo_scteip.png') }}">
        <br><br>© 2016 Secretaría de Ciencia, Tecnología e Innovación Productiva
    </p>
</div>
    
</footer>
</div>



	<script>
		$(document).ready(function() {
	    	$('#registros').DataTable( {
	    		"order": [],
			    "columnDefs": [ {
			      "targets"  : 'no-sort',
			      "orderable": false,
			    }],
				"scrollY":        "375px",
		        "scrollCollapse": true,
		        "paging":         false,
		        "searching": false
	    	} );

            $(document).ready(function () {
               var $rows = $("#1").addClass("success");

               setTimeout(function() {
                   $rows.removeClass("success");
               }, 6000);
            });

            $("#myform").submit(function() {
                $(this).submit(function() {
                    return false;
                });
                return true;
            });
		} );

		        function Reloj() {
            this.canvas=document.getElementsByTagName('canvas')[0];
            this.canvas.width=200;
            this.canvas.height=200;
            this.ctx = this.canvas.getContext('2d');

            this.setHora();
            var self=this;
            this.intervalo = setInterval(function(){self.actualizar();},1000);
        }
        Reloj.prototype.setHora=function(){
            var hora = new Date();
            this.segundos=hora.getSeconds();
            this.minutos=hora.getMinutes();
            this.horas=(hora.getHours()>12?hora.getHours()-12:(hora.getHours()==0)?12:hora.getHours());

            this.rad12=2*Math.PI/12;
            this.rad60=2*Math.PI/60;
        }
        Reloj.prototype.incrementar=function()
        {
            this.segundos=(++this.segundos)%60;
            if (this.segundos==0)
            {
                this.minutos=(++this.minutos)%60;
                if (this.minutos==0)
                {
                    this.horas=(++this.horas)%12;
                }
            }
        }
        Reloj.prototype.dibujar=function()
        {
            this.ctx.clearRect(0,0,200,200);
            this.ctx.lineWidth = 2;
            this.ctx.strokeStyle = "black";
            this.ctx.beginPath();
            this.ctx.arc(100, 100, 95, 0, 2 * Math.PI, false);
            this.ctx.stroke();

            this.ctx.save();
                this.ctx.translate(100,100);

                this.ctx.font = "bold 20px monospace";
                this.ctx.fillStyle="black";
                this.ctx.fillText(12,-12,-70);
                this.ctx.fillText(6,-6,82);
                this.ctx.fillText(1,32,-58);
                this.ctx.fillText(7,-45,70);
                this.ctx.fillText(2,60,-32);
                this.ctx.fillText(8,-72,46);
                this.ctx.fillText(3,70,5);
                this.ctx.fillText(9,-82,5);
                this.ctx.fillText(4,60,47);
                this.ctx.fillText(10,-71,-33);
                this.ctx.fillText(5,33,72);
                this.ctx.fillText(11,-47,-57);

                for (var i=0;i<30;i++)
                {
                    this.ctx.save();
                        this.ctx.rotate(i*this.rad60);
                        this.ctx.lineWidth = 2;
                        this.ctx.strokeStyle = "blue";
                        this.ctx.beginPath();
                        this.ctx.moveTo(0,-90);
                        this.ctx.lineTo(0,-95);
                        this.ctx.stroke();
                        this.ctx.beginPath();
                        this.ctx.moveTo(0,90);
                        this.ctx.lineTo(0,95);
                        this.ctx.stroke();
                    this.ctx.restore();
                }
                for (var i=0;i<6;i++)
                {
                    this.ctx.save();
                        this.ctx.rotate(i*this.rad12);
                        this.ctx.lineWidth = 5;
                        this.ctx.strokeStyle = "black";
                        this.ctx.beginPath();
                        this.ctx.moveTo(0,-85);
                        this.ctx.lineTo(0,-95);
                        this.ctx.stroke();
                        this.ctx.beginPath();
                        this.ctx.moveTo(0,85);
                        this.ctx.lineTo(0,95);
                        this.ctx.stroke();
                    this.ctx.restore();
                }

                this.ctx.save();
                    this.ctx.rotate(this.horas*this.rad12+this.minutos/60*this.rad12);
                    this.ctx.lineWidth = 7;
                    this.ctx.strokeStyle = "black";
                    this.ctx.beginPath();
                    this.ctx.moveTo(0,7);
                    this.ctx.lineTo(0,-60);
                    this.ctx.stroke();
                this.ctx.restore();

                this.ctx.save();
                    this.ctx.rotate(this.minutos*this.rad60+this.segundos/60*this.rad60);
                    this.ctx.lineWidth = 4;
                    this.ctx.strokeStyle = "black";
                    this.ctx.beginPath();
                    this.ctx.moveTo(0,10);
                    this.ctx.lineTo(0,-70);
                    this.ctx.stroke();
                this.ctx.restore();

                this.ctx.save();
                    this.ctx.rotate(this.segundos*this.rad60);
                    this.ctx.lineWidth = 1;
                    this.ctx.strokeStyle = "red";
                    this.ctx.beginPath();
                    this.ctx.moveTo(0,15);
                    this.ctx.lineTo(0,-80);
                    this.ctx.stroke();
                this.ctx.restore();

            this.ctx.restore();
            
            this.ctx.fillStyle = "red";
            this.ctx.beginPath();
            this.ctx.arc(100, 100, 4, 0, 2 * Math.PI, false);
            this.ctx.fill();
            
        }
        Reloj.prototype.actualizar=function()
        {
            this.incrementar();
            this.dibujar();
        }
        
        var reloj = new Reloj();    
	</script>

@stop