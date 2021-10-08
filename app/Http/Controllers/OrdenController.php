<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\DetalleOrden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ordenes = Orden::all();

        return view('orden.index', ["ordenes" => $ordenes]);
    }

    public function obtenerDetalleOrden(Request $request)
    {
        $detalles = DetalleOrden::where('id_orden', $request->get('idOrden'))->get();

        return response()->json($detalles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $registros = json_decode($request->get("form"));

        $orden = new Orden();
        $orden->estado = "A";
        $orden->save();

        $dataDetalle = array();
        foreach($registros as $key => $value)
        {
            array_push($dataDetalle, array(
                        'id_orden'            => $orden->id,
                        'descripcion_producto'=> $value->producto,
                        'cantidad'            => $value->cantidad,
                        'estado'              => 'A')
            );
        };

        DetalleOrden::insert($dataDetalle);

        if($orden){
            return response()->json('OK');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Orden  $orden
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Orden $orden)
    {

        $registros = json_decode($request->get("form"), true);
        $registros = array_filter($registros);
        $registros = array_values($registros);
        $detalles  = DetalleOrden::where('id_orden', $registros[0]["idOrden"])->get()->toArray();
        $arrayEditados = array();

        foreach($detalles as $keyDetalle => $valueDetalle)
        {
            foreach($registros as $key => $value)
            {
                if($valueDetalle["id"] == $value["idDetalle"])
                {
                    $detalle = DetalleOrden::find($value["idDetalle"]);
                    $detalle->descripcion_producto = $value["producto"];
                    $detalle->cantidad = $value["cantidad"];
                    $detalle->save();

                    array_push($arrayEditados, $value["idDetalle"]);
                }
            }
        }

        $editados = DetalleOrden::whereNotIn('id', $arrayEditados)->where('id_orden', $registros[0]["idOrden"])->get()->toArray();

        foreach($editados as $key => $value)
        {
                $detalle = DetalleOrden::find($value["id"]);
                $detalle->estado = 'I';
                $detalle->save();
        }

        return response()->json('OK');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Orden  $orden
     * @return \Illuminate\Http\Response
     */
    public function destroy(Orden $orden, Request $request)
    {
        DetalleOrden::where('id_orden', $request->get('idOrden'))->update(['estado' => 'I']);

        $orden = Orden::find($request->get('idOrden'));
        $orden->estado = 'I';

        $delete = $orden->save();

        if($delete){
            return response()->json('OK');
        }
    }
}
