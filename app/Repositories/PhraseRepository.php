<?php

namespace App\Repositories;

use App\Models\Phrase;
use Illuminate\Support\Facades\Gate;
use App\Http\Exceptions\ApiNotFoundException;
use App\Http\Exceptions\ApiPermissionException;
use App\Models\PhraseCategory;
use App\Models\Translation;
use Barryvdh\Debugbar\Facades\Debugbar;
use Barryvdh\Debugbar\Middleware\DebugbarEnabled;

interface IPhraseRepository
{
    public function getAllData();
    public function store($data);
    public function update($id = null,$data);
    public function upsert($data);
    public function view($id);
    public function delete($id);
    public function deleteAll($ids);
    public function find($phrase, $categoryName, $phraseCategoryName);
    public function phrasesHasPhraseCategory($categoryName);
    public function categoryTranslations($categoryName);
}

class PhraseRepository implements IPhraseRepository
{
    public function getAllData()
    {
        return Phrase::with('category')->get();
    }

    public function store($data)
    {
        $phrase = new Phrase();

        if(property_exists($data, 'base_id'))
            $phrase->base_id = $data->base_id;

        $phrase->phrase = $data->phrase;
        $phrase->category_name = $data->category_name;
        $phrase->phrase_category_id = $data->phrase_category_id;
        $phrase->save();

        return $phrase;
    }

    public function update($id = null, $data)
    {
        $phrase = Phrase::find($id);

        if(!$phrase)
            throw new ApiNotFoundException();

        if(property_exists($data, 'base_id'))
            $phrase->base_id = $data->base_id;

        $phrase->phrase = $data['phrase'];
        $phrase->category_name = $data['category_name'];
        $phrase->phrase_category_id = $data['phrase_category_id'];
        $phrase->save();

        return $phrase;
    }

    public function upsert($data)
    {
        $phrase = new Phrase();

        $phrase->phrase = $data->phrase;
        $phrase->category_name = $data->category_name;
        $phrase->phrase_category_id = $data->phrase_category_id;

        $phrase = Phrase::updateOrCreate([$phrase->phrase, $phrase->category_name, $phrase->phrase_category_id]);

        //$phrase->updateOrCreate();

        return $phrase;
    }

    public function view($id)
    {
        return Phrase::find($id)->load('category');
    }

    public function delete($id)
    {
        $phrase = Phrase::find($id);

        if(!$phrase)
            throw new ApiNotFoundException();

        return $phrase->delete();
    }

    public function deleteAll($ids)
    {
        return Phrase::whereIn('id', $ids)->delete();
    }

    public function find($phrase, $categoryName, $phraseCategoryName)
    {
        $phraseCategory = PhraseCategory::where('name', $phraseCategoryName)->first();

        if($phraseCategory)
            $phraseEntity = Phrase::where(
                [
                    ['phrase', $phrase],
                    ['category_name', $categoryName],
                    ['phrase_category_id', $phraseCategory->id],

                ]
            )->first();
        else
            $phraseEntity = Phrase::where(
                [
                    ['phrase', $phrase],
                    ['category_name', $categoryName],
                ]
            )->first();


        return $phraseEntity;
    }

    public function phrasesHasPhraseCategory($categoryName)
    {
        return Phrase::where('category_name', $categoryName)->whereNotNull('phrase_category_id');;
    }


    public function categoryTranslations($categoryName)
    {
        $phrasesIds = Phrase::where('category_name', $categoryName)->select('id')->get();

        return Translation::whereIn('phrase_id', $phrasesIds);
    }

}
