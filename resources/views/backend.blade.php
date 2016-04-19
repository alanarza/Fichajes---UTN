@extends('base')

@section('title', 'Administración - UTN')

@section('navbar')

	@parent

@stop

@section('contenido')

<div class="container">
  <div class="row">
    <div class="col-md-12" >


    	<ul class="nav nav-tabs">
		  <li class="active"><a href="#personal" data-toggle="tab">Añadir personal al sistema</a></li>
		  <li><a href="#personas" data-toggle="tab">Añadir persona</a></li>
		  <li><a href="#registros" data-toggle="tab">Registros de Entrada/salida</a></li>
		  <li><a href="#reportes" data-toggle="tab">Generar reporte</a></li>
		  <li><a href="#emergencia" data-toggle="tab">Emergencia</a></li>
		</ul>

		<div id="myTabContent" class="tab-content">

			<div class="tab-pane fade active in" id="personal">
		    <div class="panel panel-default">
			  <div class="panel-body">

			  	<div class="col-md-6">
			  		
			  		<div class="panel panel-default">
					  <div class="panel-heading">Personas</div>
					  <div class="panel-body">
					    
					  	<table id="personal1" class="table table-striped table-hover">
						  <thead>
						    <tr>
						      <th class="no-sort">#</th>
						      <th>Nombre</th>
						      <th>Dni</th>
						      <th>Acción</th>
						    </tr>
						  </thead>
						  <tbody>
						    @foreach($personas as $key=>$persona)
						    	
							    <tr>
							      <td>{{ $key + 1 }}</td>
							      <td>{{ $persona->nombre }}</td>
							      <td>{{ $persona->nro_documento }}</td>
							      <form action="{{ url("/backend/agregar") }}" method="post">
							      {!! csrf_field() !!}
							      <td><button name="id" id="id" type="submit" value="{{ $persona->id }}" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-plus"></i> &nbsp;Añadir</button></td>
							      </form>
							    </tr>
							    
							@endforeach
						  </tbody>
						</table> 
					  </div>
					</div>
					

			  	</div>

			  	<div class="col-md-6">

			  		<div class="panel panel-default">
					  <div class="panel-heading">Personal</div>
					  <div class="panel-body">
					    
					  	<table id="personal2" class="table table-striped table-hover">
						  <thead>
						    <tr>
						      <th class="no-sort">#</th>
						      <th>Nombre</th>
						      <th>Dni</th>
						      <th>Acción</th>
						    </tr>
						  </thead>
						  <tbody>
						    @foreach($personales as $key=>$personal)
							    <tr>
							      <td>{{ $key + 1 }}</td>
							      <td>{{ $personal->persona->nombre }}</td>
							      <td>{{ $personal->documento }}</td>
							      <td><button name="id" id="id" type="submit" title="Eliminar" onclick="eliminarPersonal({{ $personal->persona_id }})" value="{{ $personal->persona->id }}" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i> &nbsp;Quitar</button></td>
							    </tr>
							@endforeach
						  </tbody>
						</table> 
						
					</div>
					<div style="padding: 10px;">
					  	@if (session('status'))
					  		@if (session('codigo') == '1')
						    	<div id='mensaje' class="alert alert-success">
						    	{{ session('status') }}
						    	</div>
						   	@elseif (session('codigo') == '2')
						   		<div id='mensaje' class="alert alert-warning">
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

			  	</div>

			  </div>
			</div>
		  </div>

		  <div class="tab-pane fade" id="registros">

		  	<div class="panel panel-default">
			  <div class="panel-body">
			    
			  	<div class="col-md-12">
			  		<div class="panel panel-default">
					  <div class="panel-body">
					    <table id="personal3" class="table table-striped table-hover">
						  <thead>
						    <tr>
						      <th class="no-sort">#</th>
						      <th>Nombre</th>
						      <th>Entrada</th>
						      <th>Salida</th>
						    </tr>
						  </thead>
						  <tbody>
						    @foreach($registros as $key=>$registro)
							    <tr>
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
		  

		  <div class="tab-pane fade" id="reportes">
		    <div class="panel panel-default">
			  <div class="panel-body">
			   <div class="col-md-12" >
			  		<div class="panel panel-default">
					  <div class="panel-body">
					    <table id="registros1" class="table table-striped table-hover">
						  <thead>
						    <tr>
						      <th class="no-sort">#</th>
						      <th>Nombre</th>
						      <th>Entrada</th>
						      <th>Salida</th>
						    </tr>
						  </thead>
						  <tbody>
						  	@foreach($registros2 as $key => $registro2)
							    <tr id="{{ $registro->id }}">
							      <td>{{ $key+1 }}</td>
							      <td>{{ $registro2->personal->persona->nombre }}</td>
							      @if($registro2->entrada == NULL)
							      	<td>No se registró entrada</td>
							      @else
							      	<td>{{ $registro2->entrada }}</td>
							      @endif
							      @if($registro2->salida == NULL)
							      	<td>No se registró salida</td>
							      @else
							      	<td>{{ $registro2->salida }}</td>
							      @endif
							    </tr>
							@endforeach
						  </tbody>
						</table> 
						<br>
						<button id="exportar" class="btn btn-primary btn-lg pull-right">Exportar a XLS</button>
					  </div>
					</div>
			  	</div>
			  </div>
			</div>
		  </div>

		  <div class="tab-pane fade" id="emergencia">
		    <div class="panel panel-default">
			  <div class="panel-body">
			   <div class="col-md-10 col-md-offset-1" >
			  		<div class="panel panel-danger">
			  		  <div class="panel-heading" style="text-align: center;"><b>Emergencia</b></div>
					  <div class="panel-body">
					  	<p> Usar el botón <b>"Todos llegamos a las 8:00" SÓLO</b> en caso de <b>caídas del servidor, cortes de luz u otro tipo de errores.</b>
					  		<br> Esto hará que se <b>borren todos los registros del día</b> y se creen <b>registros nuevos con fecha actual para todo el personal</b>. 
					  		<br> Todos llegamos a las 8:00 <b>funciona sólo por un día</b>, debiéndose activar <b>cada día</b> que se necesite.
					  		<br>La necesidad de este botón se debe a que el personal <b>no puede fichar cuando hay anomalías</b> y hasta que se recupera el servidor deben fichar más tarde.
							<br><br> La <b>hora de llegada</b> de <b>todos los empleados</b> será a las <b>08:00 horas</b>, pudiendo despues fichar la salida.
							<br>Además, el activar este modo, muestra durante el día <b>(y sólo los dias donde se active)</b> un cartel indicando la situación.<br>
							<br><b> SE RECOMIENDA USAR ESTE MODO EN UN HORARIO DONDE LA MAYORIA DEL PERSONAL YA HAYA INGRESADO.</b>
					  	</p>
					  	<br>
					  	<form action="{{ url("/backend/emergencia") }}" method="post">
					  		{!! csrf_field() !!}
					  		<button class="btn btn-danger center-block"> Todos llegamos a las 8:00</button>
					  	</form>

					  	<div style="padding: 10px;">
					  	@if (session('status2'))
					    	<div id='mensaje' class="alert alert-success">
					    		{{ session('status2') }}
					    	</div>						    
						@endif
					</div>

					  </div>
					</div>
			  	</div>
			  </div>
			</div>
		  </div>

		<div class="tab-pane fade" id="personas">
		    <div class="panel panel-default">
			  <div class="panel-body">
			   <div class="col-md-10 col-md-offset-1" >
			  		<div class="panel panel-success">
			  		  <div class="panel-heading" style="text-align: center;"><b>Añadir persona</b></div>
					  <div class="panel-body">
					  	<div class="col-md-12">
						  	<form id="miform" class="form-horizontal responsive" action="{{ url("/backend/agregarPersona") }}" method="post">
						  		<div class="form-group">
							  		<label class="col-md-4 control-label"><strong>Número de documento:</strong></label>
							  		<div class="col-md-8">
							  			<div class="input-group">
							  				<span class="input-group-addon" id="sizing-addon1">DNI</span>
							  				<input name="nro_documento" id="nro_documento" class="form-control" aria-describedby="sizing-addon1" type="text" pattern="^(\d{6,10})$" placeholder="Ingrese número de documento." required autofocus>
							  			</div>
							  		</div>
							  	</div>
						  		<div class="form-group">
							  		<label class="col-md-4 control-label"><strong>Apellido:</strong></label>
							  		<div class="col-md-8">
							  			<input name="apellidos" id="apellidos" class="form-control" type="text" pattern="^[a-zA-ZñÑáÁéÉíÍóÓúÚ]+(\s*[a-zA-ZñÑáÁéÉíÍóÓúÚ]*)" placeholder="Ingrese apellido(s)." required>
							  		</div>
							  	</div>
						  		<div class="form-group">
							  		<label class="col-md-4 control-label"><strong>Nombre:</strong></label>
							  		<div class="col-md-8">
							  			<input name="nombres" id="nombres" class="form-control" type="text" pattern="^[a-zA-ZñÑáÁéÉíÍóÓúÚ]+(\s*[a-zA-ZñÑáÁéÉíÍóÓúÚ]*)" placeholder="Ingrese nombre(s)." required>
							  		</div>
							  	</div>
							  	<div class="form-group">
					                <div class="col-xs-8 col-xs-offset-4">
					                    <button type="submit" class="btn btn-success pull-right">
					                        <i class="glyphicon glyphicon-plus"></i> Agregar persona
					                    </button>
					                </div>
					            </div>
					            {!! csrf_field() !!}
						  	</form>
						  	<div>
					            @if (count($errors) > 0)
					        		<div class="alert alert-warning" role="alert">
					      				<ul>
					              			<strong>¡Ups! Algo salió mal: </strong>
					          				@foreach ($errors->all() as $error)
					          					@if($error == "The nro documento has already been taken.")
					        						<li>Ese documento ya se encuentra en Personas, quizá ya fue cargado.</li>
					        					@else
					        						<li>{{ $error }}</li>
					        					@endif
					                		@endforeach
					            		</ul>
					        		</div>
					    		@endif
							</div>
						  	<div style="padding: 10px;">
						  	@if (session('status3'))
						  		@if (session('codigo') == '1')
							    	<div id='mensaje' class="alert alert-success">
							    	{{ session('status3') }}
							    	</div>
							    @else
							    	<div id='mensaje' class="alert alert-danger">
							    	{{ session('status3') }}
							    	</div>
							   	@endif
							@endif
							</div>
						</div>
					  </div>
					</div>
			  	</div>
			  </div>
			</div>
		  </div>
		  </div>
		</div>
    </div>
  </div>
</div>

<script>

	$(document).ready(function() {

		$("#exportar").click(function(){
		  $("#registros1").table2excel({
		    // exclude CSS class
		    exclude: ".noExl",
		    name: "Registros "+"{{ $dt }}"
		  }); 
		});

		$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		    $.fn.dataTable
	        .tables( { visible: true, api: true } )
	        .columns.adjust();
		})
	    $('#personal1').DataTable( {
	    	"order": [],
		    "columnDefs": [ {
		      "targets"  : 'no-sort',
		      "orderable": false,
		    }],
			"scrollY":        "375px",
	        "scrollCollapse": true,
	        "paging":         false
	    } );
	    $('#personal3').DataTable( {
	    	"order": [],
		    "columnDefs": [ {
		      "targets"  : 'no-sort',
		      "orderable": false,
		    }],
			"scrollY":        "375px",
	        "scrollCollapse": true,
	        "paging":         false
	        

	    } );
	    $('#personal2').DataTable( {
	    	"order": [],
		    "columnDefs": [ {
		      "targets"  : 'no-sort',
		      "orderable": false,
		    }],
			"scrollY":        "355px",
	        "scrollCollapse": true,
	        "paging":         false
	    } );
	    $('#registros1').DataTable( {
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

    	// Javascript to enable link to tab
		var hash = document.location.hash;
		var prefix = "";
		if (hash) {
		    $('.nav-tabs a[href='+hash+']').tab('show');
		} 

		// Change hash for page-reload
		$('.nav-tabs a').on('shown.bs.tab', function (e) {
		    window.location.hash = e.target.hash.replace("#", "#");
		    window.scrollTo(0, 0);
		});
  	
	    $(function () {
	        $("table").each(function () {
	            
	            $.fn.dataTable.moment('YYYY-M-D H:M:S');
	            
	            $(this).DataTable();
	        });
	    });

	    String.prototype.capitalize = function(lower) {
		    return (lower ? this.toLowerCase() : this).replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); });
		};

	    var apellidos = $("#apellidos");
		var nombres = 	$("#nombres");

	    apellidos.blur(validarApellidos);
	    nombres.blur(validarNombres);

		function validarApellidos(){
			var ape = apellidos.val();
			apellidos.val(ape.capitalize(true));
		}

		function validarNombres(){
			var nom = nombres.val();
			nombres.val(nom.capitalize(true));
		}

		$("#miform").submit(function() {
            $(this).submit(function() {
                return false;
            });
            return true;
        });
	} );

	function eliminarPersonal(personal){

		if(!confirm("¿Está seguro que desea quitar este empleado del personal?"))
			return;
		$.ajax({
			url: "{{url('backend/quitar') }}/" + personal,
			type: 'POST',
			data: {
				_token: "{{ csrf_token() }}",
				_method: 'DELETE'
			},
			success: function(response) {
				window.location.href = "{{ url('/backend') }}";
			}
		});
	}

	</script>

@stop