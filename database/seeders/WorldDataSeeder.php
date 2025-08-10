<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class WorldDataSeeder extends Seeder
{
    public function run(): void
    {
        $files = [
            'regions.sql',      // if you have it
            'subregions.sql',   // if you have it
            'countries.sql',
            'states.sql',
            'cities.sql',
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // disable FK checks during import
        foreach ($files as $file) {
            $path = database_path('seeders/sql/' . $file);
            if (File::exists($path)) {
                $sql = File::get($path);

                // MySQL dump ke special commands remove karo
                $sql = preg_replace('/\/\*![0-9]+.*?\*\//s', '', $sql); // /*! ... */ comments hataye
                $sql = preg_replace('/-- Dump completed on.*/', '', $sql); // dump completed line hataye
                $sql = str_replace(');)', ');', $sql); // extra parenthesis fix

                DB::unprepared($sql);
                $this->command->info("Imported: {$file}");
            } else {
                $this->command->warn("Missing: {$file} (skipped)");
            }
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // enable back
    }
}
