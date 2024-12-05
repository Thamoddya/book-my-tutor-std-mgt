<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

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
                    'id' => $row[1],
                    'name' => $row[2],
                ]);
            }
        }
    }
}
