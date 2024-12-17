<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $path = storage_path('app/public/schools.xlsx');

        $data = Excel::toArray([], $path);

        if (!empty($data[0])) {
            foreach ($data[0] as $key => $row) {
                if ($key === 0) {
                    continue;
                }
                School::create([
                    'name' => $row[2],
                ]);
            }
        }

        $permissions = [
            'create_management_officer',
            'read_management_officer',
            'update_management_officer',
            'delete_management_officer',
            'create_school',
            'read_school',
            'update_school',
            'delete_school',
            'create_student',
            'read_student',
            'update_student',
            'delete_student',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
            ]);
        }

        $superAdminRole = Role::create(
            [
                "name" => "Super_Admin",
            ]
        );

        $superAdminRole->givePermissionTo($permissions);

        $managementOfficerRole = Role::create(
            [
                "name" => "management_officer",
            ]
        );

        $managementOfficerRole->givePermissionTo([
            'create_school',
            'read_school',
            'update_school',
            'delete_school',
            'create_student',
            'read_student',
            'update_student',
            'delete_student',
        ]);

        $superAdminOne = User::create(
            [
                'name' => 'Super Admin',
                'email' => 'ifix.digitalmedia@gmail.com',
                'nic' => '199528903459',
                'password' => Hash::make('1234'),
                'phone' => '0715880633',
                'address' => 'Eppawala',
                'status' => 1,
            ]
        );

        $superAdminOne->assignRole('Super_Admin');
    }
}
