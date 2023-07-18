<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function index()
    {
        $datos = Libro::all();
        return response()->json($datos);
    }

    public function guardar(Request $request)
    {
        $libro = new Libro;

        if ($request->hasFile('imagen')) {
            $nombreOriginal = $request->file('imagen')->getClientOriginalName();
            $nuevonombre = Carbon::now()->timestamp . "_" . $nombreOriginal;
            $carpeta_destino = './upload/'; //crea la carpeta si no existe
            $request->file('imagen')->move($carpeta_destino, $nuevonombre);
            $libro->titulo = $request->titulo;
            $libro->imagen = ltrim($carpeta_destino, '.') . $nuevonombre;
            $libro->save();
        }

        return response()->json($nuevonombre);
    }
    public function ver($id)
    {
        $libro = new Libro();
        $libroEncontrado = $libro->find($id);
        return response()->json($libroEncontrado);
    }

    public function eliminar($id)
    {
        $libro = Libro::find($id);
        if ($libro) {
            $ruta_archivo = base_path('public') . $libro->imagen;

            if (file_exists($ruta_archivo)) {
                unlink($ruta_archivo);
            }
            $libro->delete();
            return response()->json("eliminado el libro");
        } else {
            return response()->json("El libro no se encuentra en la base de datos");

        }

    }

    public function actualizar(Request $request, $id)
    {
        $libro = Libro::find($id);
        if ($request->hasFile('imagen')) {

            if ($libro) {
                $ruta_archivo = base_path('public') . $libro->imagen;

                if (file_exists($ruta_archivo)) {
                    unlink($ruta_archivo);
                }
                $libro->delete();
            }

            $nombreOriginal = $request->file('imagen')->getClientOriginalName();
            $nuevonombre = Carbon::now()->timestamp . "_" . $nombreOriginal;
            $carpeta_destino = './upload/'; //crea la carpeta si no existe
            $request->file('imagen')->move($carpeta_destino, $nuevonombre);

            $libro->imagen = ltrim($carpeta_destino, '.') . $nuevonombre;
            $libro->save();
        }
        if ($request->input('titulo')) {
            $libro->titulo = $request->input('titulo');
            $libro->save();

            return response()->json("datos actualizados");
        } else {
            return response()->json("El libro no se encuentra en la base de datos");

        }

    }
}