<?php

use App\Models\Phrase;
use Illuminate\Database\Seeder;

class PhraseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Phrase::truncate();

        $csvFile = fopen(base_path("database/data/sequences.csv"), "r");

        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {

            if (!$firstline) {

                Phrase::create([

                    "id" => $data['0'],

                    "category_name" => $data['1'],

                    "phrase" => $data['2'],

                ]);

            }

            $firstline = false;

        }

        fclose($csvFile);

        /*
        DB::table('phrases')->insert([

            'id' => 'en',

            'phrase' => 'en',

            'category_name' => 'English',

            ]);
        */
    }
}
