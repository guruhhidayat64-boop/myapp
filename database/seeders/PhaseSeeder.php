<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PhaseSeeder extends Seeder
{
    public function run(): void
    {
        $phases = [
            ['name' => 'Fase A', 'description' => 'Umumnya untuk kelas 1 - 2 SD'],
            ['name' => 'Fase B', 'description' => 'Umumnya untuk kelas 3 - 4 SD'],
            ['name' => 'Fase C', 'description' => 'Umumnya untuk kelas 5 - 6 SD'],
            ['name' => 'Fase D', 'description' => 'Umumnya untuk kelas 7 - 9 SMP'],
            ['name' => 'Fase E', 'description' => 'Umumnya untuk kelas 10 SMA/SMK'],
            ['name' => 'Fase F', 'description' => 'Umumnya untuk kelas 11 - 12 SMA/SMK'],
        ];
        foreach ($phases as $phase) {
            DB::table('phases')->insert($phase + ['created_at' => now(), 'updated_at' => now()]);
        }
    }
}