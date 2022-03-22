<?php

use App\Models\Translation;
use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Phrase::truncate();

        $csvFile = fopen(base_path("database/data/translations.csv"), "r");

        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {

            if (!$firstline) {

                Translation::create([

                    "id" => $data['0'],

                    //"category_name" => $data['1'],

                    "language_id" => $data['2'],

                    "phrase_id" => $data['3'],

                    "translation" => $data['4'],

                ]);

            }

            $firstline = false;

        }

        fclose($csvFile);
    }
}
