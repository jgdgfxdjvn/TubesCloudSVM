<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;
use Faker\Factory;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        Item::query()->create([
            'unit_id' => 1,
            'code' => '001',
            'name' => 'Iguana',
            'price' => 500000,
            'desc' => $faker->text(200),
            'stock' => 50
        ]);

        Item::query()->create([
            'unit_id' => 1,
            'code' => '002',
            'name' => 'ular',
            'price' => 160999,
            'desc' => $faker->text(200),
            'stock' => 50
        ]);

        Item::query()->create([
            'unit_id' => 1,
            'code' => '003',
            'name' => 'Gecko',
            'price' => 550000,
            'desc' => $faker->text(200),
            'stock' => 60
        ]);

        Item::query()->create([
            'unit_id' => 1,
            'code' => '004',
            'name' => 'Soalayar',
            'price' => 280000,
            'desc' => $faker->text(200),
            'stock' => 70
        ]);

        Item::query()->create([
            'unit_id' => 1,
            'code' => '005',
            'name' => 'Biawak',
            'price' => 1550000,
            'desc' => $faker->text(200),
            'stock' => 10
        ]);
    }
}
