<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PacientesController extends Controller
{
    public function index() {
        $pacientes = User::where('rol_id', 3)->get();

        return response()->json([
            'pacientes' => $pacientes
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
                'telefono' => ['required', 'integer', 'unique:'.User::class],
                'fecha_na' => ['required'],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('12345678'),
                'telefono' => $request->telefono,
                'fecha_na' => Carbon::parse($request->fecha_na)->format('Y-m-d'),
                'rol_id' => 3
            ]);

            return response()->json([
                'paciente' => $user
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        }
    }
}
