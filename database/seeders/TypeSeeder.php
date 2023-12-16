<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $_types = [
            [
                'label' => 'Front-End',
                'color' => '#22d835',
            ],
            [
                'label' => 'Back-End',
                'color' => '#54aedb',
            ],
            [
                'label' => 'Full-Stack',
                'color' => '#cdc245',
            ],
        ];

        foreach ($_types as $_type) {
            $types = new Type();
            $types->label = $_type['label'];
            $types->color = $_type['color'];
            $types->save();
        }
    }
}
