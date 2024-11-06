<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usar firstOrCreate en lugar de create para evitar duplicados
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $empresa = Role::firstOrCreate(['name' => 'empresa']);
        $postulante = Role::firstOrCreate(['name' => 'postulante']);
        $supervisor = Role::firstOrCreate(['name' => 'supervisor']);

        // Crear permisos
        Permission::firstOrCreate(['name' => 'edit articles']);
        Permission::firstOrCreate(['name' => 'delete articles']);
        Permission::firstOrCreate(['name' => 'publish articles']);
        Permission::firstOrCreate(['name' => 'unpublish articles']);

        // Asignar permisos a roles si no están ya asignados
        $admin->syncPermissions(Permission::all());
        $empresa->syncPermissions(['edit articles']);
        $supervisor->syncPermissions(['publish articles', 'unpublish articles']);
    }
}
