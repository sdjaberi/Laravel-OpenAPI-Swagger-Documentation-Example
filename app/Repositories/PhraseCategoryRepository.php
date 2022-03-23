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
    public function getAllData();
    public function store($data);
    public function update($id = null,$data);
    public function upsert($data);
    public function view($id);
    public function delete($id);
    public function deleteAll($ids);
    public function findByName($phraseCategoryName);
}

class PhraseCategoryRepository implements IPhraseCategoryRepository
{
    public function getAllData()
    {
        return PhraseCategory::all();
    }

    public function store($data)
    {
        $phraseCategory = new PhraseCategory();
        $phraseCategory->name = $data->name;
        $phraseCategory->filename = $data->filename;
        $phraseCategory->save();

        return $phraseCategory;
    }

    public function update($id = null, $data)
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

    public function view($id)
    {
        return PhraseCategory::find($id);
    }

    public function delete($id)
    {
        return PhraseCategory::find($id)->delete();
    }

    public function deleteAll($ids)
    {
        return PhraseCategory::whereIn('id', $ids)->delete();
    }

    public function findByName($phraseCategoryName)
    {
        return PhraseCategory::where('name', $phraseCategoryName)->first();
    }
}
