<?php

namespace App\Repositories;

use App\Models\Translation;
use Illuminate\Support\Facades\Gate;
use App\Http\Exceptions\ApiNotFoundException;
use App\Http\Exceptions\ApiPermissionException;
use Barryvdh\Debugbar\Facades\Debugbar;
use Barryvdh\Debugbar\Middleware\DebugbarEnabled;

interface ITranslationRepository
{
    public function getAllData();
    public function store($data);
    public function update($id = null,$data);
    public function view($id);
    public function delete($id);
    public function deleteAll($ids);
}

class TranslationRepository implements ITranslationRepository
{
    public function getAllData()
    {
        return Translation::with('phrase','language','author')->get();
    }

    public function store($data)
    {
        $translation = new Translation();
        $translation->translation = $data['translation'];
        $translation->phrase_id = $data['phrase_id'];
        $translation->language_id = $data['language_id'];
        $translation->user_id = $data['user_id'];
        $translation->save();

        return $translation;
    }

    public function update($id = null, $data)
    {
        $translation = Translation::find($id);

        if(!$translation)
            throw new ApiNotFoundException();

        $translation->translation = $data['translation'];
        $translation->phrase_id = $data['phrase_id'];
        $translation->language_id = $data['language_id'];
        $translation->user_id = $data['user_id'];
        $translation->save();

        return $translation;
    }

    public function view($id)
    {
        return Translation::find($id)->load('phrase','language','author');
    }

    public function delete($id)
    {
        return Translation::find($id)->delete();
    }

    public function deleteAll($ids)
    {
        return Translation::whereIn('id', $ids)->delete();
    }


}
