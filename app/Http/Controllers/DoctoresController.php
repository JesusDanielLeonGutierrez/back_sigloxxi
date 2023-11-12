<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class DoctoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctores = User::where('rol_id', 2)->get();

        return response()->json([
            'doctores' => $doctores
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'telefono' => ['required', 'integer', 'unique:'.User::class],
            'fecha_na' => ['required', 'date'],
            'no_cedula' => ['required', 'integer'],
            'consultorio' => ['required', 'string']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => '12345678',
            'telefono' => $request->telefono,
            'fecha_na' => Carbon::parse($request->fecha_na)->format('Y-m-d'),
            'no_cedula' => $request->no_cedula,
            'consultorio' => $request->consultorio,
            'rol_id' => 2
        ]);

        return response()->json([
            'message' => 'User created',
            'user' => $user
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255', 'unique:'.User::class],
            'telefono' => ['integer', 'unique:'.User::class],
            'fecha_na' => ['date'],
            'password' => [Rules\Password::defaults()],
            'no_cedula' => ['integer'],
            'consultorio' => ['string']
        ]);

        $user=User::find($id);

        if ($request->password != null) {
            $user->update([
                'password' => Hash::make($request->password)
            ], $request->all());
        }

        $user->update($request->all());

        return response()->json([
            'message' => 'User updated',
            'user' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user)
    {
        $user=User::find($user);

        $user->delete();

        return response()->json([
            'message' => 'User deleted'
        ]);
    }
}
