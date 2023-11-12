<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Rol;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Rol::create([
            'name' => 'Administrador'
        ]);

        Rol::create([
            'name' => 'Doctor'
        ]);

        Rol::create([
            'name' => 'Paciente'
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@sigloxxi.com',
            'password' => '12345678',
            'fecha_na' => Carbon::now(),
            'telefono' => '0000000000',
            'rol_id' => 1
        ]);

        User::create([
            'name' => 'Doctor',
            'email' => 'doctor@sigloxxi.com',
            'password' => '12345678',
            'fecha_na' => Carbon::now(),
            'telefono' => '1000000000',
            'no_cedula' => '243535325432',
            'consultorio' => 'Av. AFDSAAAFAS, Lerma de Villada, Mexico, Mexico',
            'rol_id' => 2
        ]);
    }
}
