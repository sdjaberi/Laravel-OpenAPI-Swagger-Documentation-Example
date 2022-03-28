<?php

namespace App\Repositories;

use App\Models\PhraseCategory;
use Illuminate\Support\Facades\Gate;
use App\Http\Exceptions\ApiNotFoundException;
use App\Http\Exceptions\ApiPermissionException;
use Barryvdh\Debugbar\Facades\Debugbar;
use Barryvdh\Debugbar\Middleware\DebugbarEnabled;

interface IPhraseCategoryRepository
{
    public function getAllAsync();
    public function storeAsync($data);
    public function updateAsync($id = null,$data);
    public function upsert($data);
    public function viewAsync($id);
    public function deleteAsync($id);
    public function deleteAllAsync($ids);
    public function findByName($phraseCategoryName);
}

class PhraseCategoryRepository implements IPhraseCategoryRepository
{
    public function getAllAsync()
    {
        return PhraseCategory::all();
    }

    public function storeAsync($data)
    {
        $phraseCategory = new PhraseCategory();
        $phraseCategory->name = $data->name;
        $phraseCategory->filename = $data->filename;
        $phraseCategory->save();

        return $phraseCategory;
    }

    public function updateAsync($id = null, $data)
    {
        $phraseCategory = PhraseCategory::find($id);

        if(!$phraseCategory)
            throw new ApiNotFoundException();

        $phraseCategory->name = $data->name;
        $phraseCategory->filename = $data->filename;
        $phraseCategory->save();

        return $phraseCategory;
    }

    public function upsert($data)
    {
        $phraseCategory = new PhraseCategory();

        $phraseCategory->name = $data->name;
        $phraseCategory->filename = $data->filename;

        //dd($phraseCategory);

        $phraseCategory = PhraseCategory::updateOrCreate([$phraseCategory->name, $phraseCategory->filename]);

        //$phraseCategory->updateOrCreate();

        return $phraseCategory;
    }

    public function viewAsync($id)
    {
        return PhraseCategory::find($id);
    }

    public function deleteAsync($id)
    {
        return PhraseCategory::find($id)->deleteAsync();
    }

    public function deleteAllAsync($ids)
    {
        return PhraseCategory::whereIn('id', $ids)->deleteAsync();
    }

    public function findByName($phraseCategoryName)
    {
        return PhraseCategory::where('name', $phraseCategoryName)->first();
    }
}
