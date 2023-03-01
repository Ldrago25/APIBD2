<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GlobalVariableController extends Controller
{
    public function actualizarEstatus(Request $request)
    {
       
        $nuevoEstatus = filter_var($request->input('estatus'), FILTER_VALIDATE_BOOLEAN);
        $envFilePath = base_path('.env');
        $fileContents = file_get_contents($envFilePath);
        $fileContents = preg_replace('/ESTATUS_ACTUALIZAR=(.*)/', 'ESTATUS_ACTUALIZAR=' . var_export($nuevoEstatus, true), $fileContents);
        file_put_contents($envFilePath, $fileContents);

        $estatus = filter_var(env('ESTATUS_ACTUALIZAR'), FILTER_VALIDATE_BOOLEAN);
        // var_dump($estatus);

        return response()->json([
        'estatus' => $nuevoEstatus,
        'success' => true,
        'message' => 'El estatus se ha actualizado correctamente.'
        ]);
    }
}
