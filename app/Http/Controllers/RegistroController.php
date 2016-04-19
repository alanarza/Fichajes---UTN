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
use DB;

class RegistroController extends Controller
{
    public function fichaje(Request $req)
    {

    	$dni = $req->input('dni');
        if ($dni == NULL) {
            return redirect('/')->with('codigo', '3')->with('status', 'Documento no válido.');       
        }

        $doc = DB::table('personal')->where('documento', $dni)->get();

        if ($doc == NULL) {
            return redirect('/')->with('codigo', '3')->with('status', 'Documento no válido o empleado no registrado en el sistema.');       
        }

        $ultimo_registro = DB::table('personal')
                               ->join('registro_es', 'persona_id', '=', 'personal_id')
                               ->select('id', 'personal_id', 'entrada', 'salida')
                               ->where('documento', $dni)
                               ->orderBy('id', 'desc')
                               ->first();
        
        $hoy = Carbon::now()->format('d-m-Y');

        $hora = Carbon::now();
        $hora = $hora->toTimeString();

        if ($ultimo_registro != NULL) {
        
            if ($ultimo_registro->entrada != NULL) {
                
                $d = DateTime::createFromFormat("Y-m-d H:i:s", $ultimo_registro->entrada);
                $ultimo_registro->entrada = $d->format("d-m-Y"); 
                
            }

            if ($ultimo_registro->salida != NULL) {
                
                $d = DateTime::createFromFormat("Y-m-d H:i:s", $ultimo_registro->salida);
                $ultimo_registro->salida = $d->format("d-m-Y"); 

            }
        }

        if($ultimo_registro == NULL || strtotime($ultimo_registro->entrada) < strtotime('today')) 
        {
            $registro = new Registro;

            $registro->personal_id = Personal::where('documento', $dni)->value('persona_id');

            $registro->entrada = Carbon::now()->toDateTimeString();

            $registro->save();

            return redirect('/')->with('codigo', '1')->with('status', 'Entrada registrada correctamente. ¡Buenos días!');

        }
        else if($ultimo_registro == NULL || strtotime($ultimo_registro->salida) < strtotime('today'))
        {
            if ($ultimo_registro == NULL || Registro::where('id', $ultimo_registro->id)->whereDate("entrada", ">=", Carbon::today()->toDateString())->first() == NULL) {
                
                $ultimo_registro = new Registro;

                $ultimo_registro->personal_id = Personal::where('documento', $dni)->value('persona_id');

            }
            else
            {
                
                $ultimo_registro = Registro::where('id', $ultimo_registro->id)->whereDate("entrada", ">=", Carbon::today()->toDateString())->first();    

            }

            $ultimo_registro->salida = Carbon::now()->toDateTimeString();

            $ultimo_registro->save();

            return redirect('/')->with('codigo', '1')->with('status', 'Salida registrada correctamente. ¡Hasta luego!');

        }
        else if ($ultimo_registro != NULL && ($ultimo_registro->entrada == $hoy && $ultimo_registro->salida == $hoy)) {
            $registro = new Registro;

            $registro->personal_id = Personal::where('documento', $dni)->value('persona_id');
            $registro->entrada = Carbon::now()->toDateTimeString();

            $registro->save();

            return redirect('/')->with('codigo', '1')->with('status', 'Entrada registrada correctamente. Usted ha registrado más de una entrada hoy.');
        }
        else
        {
            return redirect('/')->with('codigo', '3')->with('status', 'Error procesando la solicitud.');       
        }
    }
}
