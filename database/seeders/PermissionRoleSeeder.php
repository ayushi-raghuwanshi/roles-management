<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super_admin_permissions = Permission::pluck('id');
        Role::findOrFail(1)->permissions()->sync($super_admin_permissions);
        $user_permissions = array_slice($super_admin_permissions->toArray(), 0, 4);
        Role::findOrFail(2)->permissions()->sync($user_permissions);
    }
}
