<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $labels = ['HTML', 'CSS', 'Vue.js', 'JavaScript', 'Node.JS', 'PHP', 'Bootstrap', 'SCSS', 'Laravel'];

        foreach ($labels as $label) {
            $language = new Language();
            $language->label = $label;
            $language->save();
        }
    }
}
