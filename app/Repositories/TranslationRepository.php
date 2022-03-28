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
    public function getAllAsync();
    public function storeAsync($data);
    public function updateAsync($id = null,$data);
    public function viewAsync($id);
    public function deleteAsync($id);
    public function deleteAllAsync($ids);
}

class TranslationRepository implements ITranslationRepository
{
    public function getAllAsync()
    {
        return Translation::with('phrase','language','author')->get();
    }

    public function storeAsync($data)
    {
        $translation = new Translation();
        $translation->translation = $data['translation'];
        $translation->phrase_id = $data['phrase_id'];
        $translation->language_id = $data['language_id'];
        $translation->user_id = $data['user_id'];
        $translation->save();

        return $translation;
    }

    public function updateAsync($id = null, $data)
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

    public function viewAsync($id)
    {
        return Translation::find($id)->load('phrase','language','author');
    }

    public function deleteAsync($id)
    {
        return Translation::find($id)->deleteAsync();
    }

    public function deleteAllAsync($ids)
    {
        return Translation::whereIn('id', $ids)->deleteAsync();
    }


}
