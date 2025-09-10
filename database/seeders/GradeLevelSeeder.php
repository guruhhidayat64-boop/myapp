<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class GradeLevelSeeder extends Seeder
{
    public function run(): void
    {
        $grades = [
            ['phase_id' => 1, 'name' => 'Kelas 1'], ['phase_id' => 1, 'name' => 'Kelas 2'],
            ['phase_id' => 2, 'name' => 'Kelas 3'], ['phase_id' => 2, 'name' => 'Kelas 4'],
            ['phase_id' => 3, 'name' => 'Kelas 5'], ['phase_id' => 3, 'name' => 'Kelas 6'],
            ['phase_id' => 4, 'name' => 'Kelas 7'], ['phase_id' => 4, 'name' => 'Kelas 8'], ['phase_id' => 4, 'name' => 'Kelas 9'],
            ['phase_id' => 5, 'name' => 'Kelas 10'],
            ['phase_id' => 6, 'name' => 'Kelas 11'], ['phase_id' => 6, 'name' => 'Kelas 12'],
        ];
        foreach ($grades as $grade) {
            DB::table('grade_levels')->insert($grade + ['created_at' => now(), 'updated_at' => now()]);
        }
    }
}
