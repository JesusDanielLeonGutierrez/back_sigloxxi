<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rol_id = Auth::user()->rol_id;
        if($rol_id === 1) {
            $citas = Citas::with('medico')->get();
        }
        elseif ($rol_id === 2) {
            $citas = Citas::where('medico_id', Auth::user()->id)->with('medico')->get();
        }
        else {
            $citas = Citas::where('paciente_id', Auth::user()->id)->with('medico')->get();
        }

        return response()->json([
            'citas' => $citas
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha_consulta' => ['required', 'date'],
        ]);

        $rol_id = Auth::user()->rol_id;

        if($rol_id !== 3) {
            $cita = Citas::create([
                'paciente_id' => $request->paciente_id,
                'medico_id' => Auth::user()->id,
                'fecha_consulta' => $request->fecha_consulta,
            ]);
        }
        else {
            $cita = Citas::create([
                'paciente_id' => Auth::user()->id,
                'medico_id' => $request->medico_id,
                'fecha_consulta' => $request->fecha_consulta,
            ]);
        }

        return response()->json([
            'message' => 'Cita creada',
            'cita' => $cita
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $rol_id = Auth::user()->rol_id;
        if($rol_id === 2) {
            $request->validate([
                'nota' => ['required', 'string'],
            ]);
            $cita = Citas::find($id);
            $cita->update([
                'nota' => $request->nota
            ]);
        }
        else {
            $request->validate([
                'fecha_consulta' => ['required', 'date'],
            ]);

            $cita = Citas::find($id);
            $cita->update($request->all());
        }

        return response()->json([
            'message' => 'Cita Actualizada',
            'cita' => $cita
        ]);
    }

    public function destroy($citas)
    {
        $citas=Citas::find($citas);
        $citas->delete();

        return response()->json([
            'message' => 'Cita deleted'
        ]);
    }
}
