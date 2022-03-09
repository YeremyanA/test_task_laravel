<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $backwardDays = -800;



        for ($i = 0; $i < 100; $i++) {
            $backwardCreatedDays = rand($backwardDays, 0);
            $backwardUpdatedDays = rand($backwardCreatedDays + 1, 0);
            DB::table('products')->insert([
                'name' => Str::random(10),
                'author_name' => Str::random(12),
                'created_at' => \Carbon\Carbon::now()->addDays($backwardCreatedDays)->addMinutes(rand(0,
                    60 * 23))->addSeconds(rand(0, 60)),
                'updated_at' => \Carbon\Carbon::now()->addDays($backwardUpdatedDays)->addMinutes(rand(0,
                    60 * 23))->addSeconds(rand(0, 60))
            ]);
        }
    }
}
