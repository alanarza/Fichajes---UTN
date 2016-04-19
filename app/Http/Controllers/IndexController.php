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

class IndexController extends Controller
{
    public function index() 
    {

    	$hoy = Carbon::today();

    	$registros = Registro::whereDate("entrada", ">=", Carbon::today()->toDateString())->orWhereDate("salida", ">=", Carbon::today()->toDateString())->orderBy('lastmodified', 'DESC')->get();

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

        $dt = Carbon::today()->formatLocalized('%A %d/%m/%Y');

        $arr = explode(' ',trim($dt));

        switch ($arr[0]) {
            case "Monday":
                $arr[0] = "Lunes";
                break;
            case "Tuesday":
                $arr[0] = "Martes";
                break;
            case "Wednesday":
                $arr[0] = "Miércoles";
                break;
            case "Thursday":
                $arr[0] = "Jueves";
                break;
            case "Friday":
                $arr[0] = "Viernes";
                break;
            case "Saturday":
                $arr[0] = "Sábado";
                break;
            case "Sunday":
                $arr[0] = "Domingo";
                break;
            default:
                # code...
                break;
        }

        $dt = implode(' ', $arr);

    	return view('index', compact('registros', 'dt'));
    }
}
