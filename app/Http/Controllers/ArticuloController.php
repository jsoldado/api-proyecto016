<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\Http\Request;

class ArticuloController extends Controller
{
    public function index()
    {

        $articulos = Articulo::all();
        return response()->json(array(
            'articulos' => $articulos,
            'status' => 'success'
        ), 200);
    }

    public function show($id)
    {
        $articulo = Articulo::find($id);
        if (is_object($articulo)) {
            $articulo = Articulo::find($id);
            return response()->json(array('articulo' => $articulo, 'status' => 'success'), 200);
        } else {
            return response()->json(array('message' => 'El artículo no existe', 'status' => 'error'), 200);
        }
    }

    public function destroy($id)
    {

        // Comprobar que existe el registro
        $articulo = Articulo::find($id);

        //var_dump($articulo);
        //die();

        if (!is_null($articulo)) { // ¡¡OJO!! COMPROBACIÓN ADICIONAL QUE HE AÑADIDO POR SI CAR NO EXISTE
            // Borrarlo
            $articulo->delete();

            // Devolverlo
            $data = array(
                'articulo' => $articulo,
                'status' => 'success',
                'code' => 200
            );
        } else {
            $data = array(
                'status' => 'error',
                'code'     => 400,
                'message' => 'No existe el registro !!'
            );
        }

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        

        // Recoger datos por POST
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

  
        //var_dump($params_array); die();

        // Validación
        $validate = \Validator::make($params_array, [
            'descripcion' => 'required|min:5',
            'precio' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        // Guardar el coche
        $articulo = new Articulo();
        $articulo->descripcion = $params->descripcion;
        $articulo->precio = $params->precio;
        $articulo->save();

        $data = array(
            'articulo' => $articulo,
            'status' => 'success',
            'code' => 200,
        );

        return response()->json($data, 200);
    }

    public function update($id, Request $request)
    {
        // Recoger parametros POST
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        //var_dump($params);
        //var_dump($params_array);
        //die();

        // Validar datos
        $validate = \Validator::make($params_array, [
            'descripcion' => 'required|min:5',
            'precio' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        // Actualizar el registro
        unset($params_array['id']);
        unset($params_array['created_at']);
        unset($params_array['updated_at']);

        //var_dump($params_array);die();

        $articulo = Articulo::where('id', $id)->update($params_array);

        $data = array(
            'articulo' => $params,
            'status' => 'success',
            'code' => 200
        );

        return response()->json($data, 200);
    }
}
