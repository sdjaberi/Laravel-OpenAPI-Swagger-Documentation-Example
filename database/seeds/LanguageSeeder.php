<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->insert([

            'iso_code' => 'en',

            'title' => 'English',

            'local_name' => 'English'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'de',

            'title' => 'German',

            'local_name' => 'Deutsch'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'ru',

            'title' => 'Russian',

            'local_name' => 'Pусский'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'fr',

            'title' => 'French',

            'local_name' => 'Français'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'zh',

            'title' => 'Chinese',

            'local_name' => '中文'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'he',

            'title' => 'Hebrew',

            'local_name' => 'עברית'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'es',

            'title' => 'Spanish',

            'local_name' => 'Español'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'pl',

            'title' => 'Polish',

            'local_name' => 'Polskie'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'tr',

            'title' => 'Turkish',

            'local_name' => 'Türk'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'it',

            'title' => 'Italian',

            'local_name' => 'Italiano'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'no',

            'title' => 'Norwegian',

            'local_name' => 'Norsk'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'nl',

            'title' => 'Dutch',

            'local_name' => 'Nederlands'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'el',

            'title' => 'Greek',

            'local_name' => 'Ελληνικά'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'ar',

            'title' => 'Arabic',

            'local_name' => 'عربى'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'fa',

            'title' => 'Persian',

            'local_name' => 'فارسی'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'pt',

            'title' => 'Portuguese',

            'local_name' => 'Português'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'ro',

            'title' => 'Romanian',

            'local_name' => 'Română'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'br',

            'title' => 'Brazilian',

            'local_name' => 'Brasileiro'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'sk',

            'title' => 'Slovak',

            'local_name' => 'Slovenský'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'cz',

            'title' => 'Czech',

            'local_name' => 'Češka'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'se',

            'title' => 'Swedish',

            'local_name' => 'Svenska'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'id',

            'title' => 'Indonesian',

            'local_name' => 'Bahasa Indonesia'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'hu',

            'title' => 'Hungarian',

            'local_name' => 'Magyar'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'ja',

            'title' => 'Japanese',

            'local_name' => '日本語'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'dk',

            'title' => 'Danish',

            'local_name' => 'Dansk'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'th',

            'title' => 'Thai',

            'local_name' => 'ไทย'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'VN',

            'title' => 'Vietnamese',

            'local_name' => 'Tiếng Việt'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'my',

            'title' => 'Malaysian',

            'local_name' => 'Orang Malaysia'

            ]);

            DB::table('languages')->insert([

            'iso_code' => 'fi',

            'title' => 'Finnish',

            'local_name' => 'Suomi'

            ]);
    }
}
