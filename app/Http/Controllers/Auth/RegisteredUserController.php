<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', Rules\Password::defaults()],
                'telefono' => ['required', 'integer', 'unique:'.User::class],
                'fecha_na' => ['required'],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'telefono' => $request->telefono,
                'fecha_na' => Carbon::parse($request->fecha_na)->format('Y-m-d'),
                'rol_id' => 3
            ]);

            event(new Registered($user));

            Auth::login($user);

            $token=Auth::user()->createToken(Auth::user()->name)->plainTextToken;

            return response()->json([
                'token' => $token
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        }
    }
}
