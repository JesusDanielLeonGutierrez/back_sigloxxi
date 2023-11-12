<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormularioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $form = Formulario::where('paciente_id', Auth::user()->id)->first();

        if ($form !== null) {
            return response()->json('Encuesta ya ha sido creada', 302);
        }
        return response()->json('Encuesta no ha sido creada');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'puntaje' => ['required', 'integer'],
            'edad' => ['required', 'integer']
        ]);

        Formulario::create([
            'puntaje' => $request->puntaje,
            'edad' => $request->edad,
            'paciente_id' => Auth::user()->id
        ]);

        return response()->json('Form created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Formulario $formulario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Formulario $formulario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Formulario $formulario)
    {
        //
    }
}
