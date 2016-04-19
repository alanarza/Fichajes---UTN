<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Registro;
use App\Persona;
use App\Personal;
use Carbon\Carbon;
use DateTime;
use Validator;
use App\User;

class BackendController extends Controller
{

	public function __construct()
	{
	    $this->middleware('auth');
	}
	
	public function backend()
	{
		$registros = Registro::orderBy('entrada')->get();

		foreach ($registros as $registro) {
			if ($registro->entrada != NULL) {
				$d = DateTime::createFromFormat("Y-m-d H:i:s", $registro->entrada);
            	$registro->entrada = $d->format("d/m/Y H:i:s"); 				
			}

			if ($registro->salida != NULL) {
				$d = DateTime::createFromFormat("Y-m-d H:i:s", $registro->salida);
            	$registro->salida = $d->format("d/m/Y H:i:s"); 				
			}
    	}

		$personas = Persona::join('personal', 'documento', '=', 'nro_documento', 'left')
		                     
		                     ->where('personal.documento', NULL)
		                     ->orderBy('nombre')
		                     ->get();

		$personales = Personal::join('persona', 'nro_documento', '=', 'documento')->orderBy('persona.nombre')->get();

		$hoy = Carbon::today();

    	$registros2 = Registro::whereDate("entrada", ">=", Carbon::today()->toDateString())->orWhereDate("salida", ">=", Carbon::today()->toDateString())->orderBy('entrada', 'DESC')->get();

    	foreach ($registros2 as $registro2) {
    		if ($registro2->entrada != NULL) {
				$d = DateTime::createFromFormat("Y-m-d H:i:s", $registro2->entrada);
            	$registro2->entrada = $d->format("d/m/Y H:i:s"); 				
			}

			if ($registro2->salida != NULL) {
				$d = DateTime::createFromFormat("Y-m-d H:i:s", $registro2->salida);
            	$registro2->salida = $d->format("d/m/Y H:i:s"); 				
			}
    	}

    	$dt = Carbon::now()->format('d/m/Y');

		return view('backend', compact('registros', 'personas', 'personales', 'registros2', 'dt'));
	}

	public function agregar(Request $req)
	{

		$id = $req->input('id');

        $persona = Persona::find($id);

        if ($persona->nro_documento != NULL) {
        
        	$personal = new Personal;

        	$personal->persona_id = $persona->id;
	        $personal->documento = $persona->nro_documento;

	        $personal->save();
        }
        else
        {
			return redirect('/backend')->with('codigo', '3')->with('status', 'Error');
        }
        
		return redirect('/backend')->with('codigo', '1')->with('status', 'Personal agregado correctamente.');

	}

	public function destroy($id)
    {
        Personal::find($id)->delete();
        
        return redirect('/backend');
    }

    public function emergencia()
    {
    	$hoy2 = Registro::whereDate("entrada", '>=', Carbon::today()->toDateString())->delete();

    	$personales2 = Personal::join('persona', 'nro_documento', '=', 'documento')->get();

    	foreach ($personales2 as $personal2) {
			$entrada = new Registro;

			$entrada->personal_id = $personal2->persona_id;
	        $entrada->entrada = Carbon::now()->format('Y-m-d') . " 08:00:00";
	        $entrada->save();    		
    	}

    	return redirect('/backend#emergencia')->with('status2', 'Registros de personal con llegada a las 8:00 creados.');
    }

    public function agregarPersona(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'nro_documento' => 'unique:persona'
        ]);

        if ($validator->fails()) {
            return redirect('/backend#personas')
                        ->withErrors($validator)
                        ->withInput();
        }

    	$persona = new Persona;

    	$persona->nombres = $req->input('nombres');
    	$persona->apellidos = $req->input('apellidos');
    	$persona->nro_documento = $req->input('nro_documento');
    	$persona->nombre = $persona->apellidos . ", " . $persona->nombres;

    	if ($persona->save()) {
    		return redirect('/backend#personas')->with('codigo', '1')->with('status3', 'Persona creada correctamente.');	
    	}

    	return redirect('/backend#personas')->with('codigo', '3')->with('status3', 'Error al crear persona.');
    }

    public function crear_usuario(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'name'      => 'required|max:255',
            'username'  => 'required|unique:users|max:255',
            'password'  => 'required|confirmed|min:6',
            'email'     => 'email|unique:users',
        ]);

        if ($validator->fails()) {
            return redirect('/crear_usuario')
                        ->withErrors($validator)
                        ->withInput();
        }

        $usuario = new User;

        $usuario->password = bcrypt($req->input('password'));

        $usuario->name = $req->input('name');

        $usuario->username = $req->input('username');

        $usuario->email = $req->input('email');

        $usuario->permisos = 2;

        if ($usuario->save())
            return redirect('/crear_usuario')->with('codigo', '1')->with('status4', 'Usuario creado exitosamente.');    
        else
            return redirect('/crear_usuario')->with('codigo', '3')->with('status4', 'Error el crear usuario.');        
        
    }
}
