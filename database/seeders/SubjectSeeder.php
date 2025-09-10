<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            ['name' => 'Pendidikan Agama'], ['name' => 'PPKn'],
            ['name' => 'Bahasa Indonesia'], ['name' => 'Matematika'],
            ['name' => 'IPA'], ['name' => 'IPS'],
            ['name' => 'Bahasa Inggris'], ['name' => 'PJOK'],
            ['name' => 'Informatika'], ['name' => 'Seni Budaya'],
        ];
        foreach ($subjects as $subject) {
            DB::table('subjects')->insert($subject + ['created_at' => now(), 'updated_at' => now()]);
        }
    }
}