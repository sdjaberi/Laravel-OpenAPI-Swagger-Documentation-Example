<?php

namespace App\Repositories;

use App\Models\Language;
use App\Http\Exceptions\ApiNotFoundException;

interface ILanguageRepository
{
    public function getAllData();
    public function getAllNotPrimaryData();
    public function getAllActiveData();
    public function getPrimaryData();
    public function store($data);
    public function update($id = null,$data);
    public function view($id);
    public function delete($id);
    public function deleteAll($ids);
}

class LanguageRepository implements ILanguageRepository
{
    public function getAllData()
    {
        return Language::all();
    }

    public function getAllNotPrimaryData()
    {
        return Language::where('is_primary', 0);

    }

    public function getAllActiveData()
    {
        return Language::where('active', 1);
    }

    public function getPrimaryData()
    {
        return Language::where('is_primary', 1)->first();
    }

    public function store($data)
    {
        $language = new Language();
        $language->title = $data['title'];
        $language->iso_code = $data['iso_code'];
        $language->local_name = $data['local_name'];
        $language->text_direction = $data['text_direction'];
        $language->active = !$data['active'] ? 1 : 0;
        $language->is_primary = $data['is_primary'] ? 1 : 0;
        $language->save();

        return $language;
    }

    public function update($id = null, $data)
    {
        $language = Language::find($id);

        if(!$language)
            throw new ApiNotFoundException();

        $language->title = $data['title'];
        $language->iso_code = $data['iso_code'];
        $language->local_name = $data['local_name'];
        $language->text_direction = $data['text_direction'];
        $language->active = $data['active'] ? 1 : 0;
        $language->is_primary = $data['is_primary'] ? 1 : 0;
        $language->save();

        return $language;
    }

    public function view($id)
    {
        return Language::find($id);
    }

    public function delete($id)
    {
        return Language::find($id)->delete();
    }

    public function deleteAll($ids)
    {
        return Language::whereIn('id', $ids)->delete();
    }
}
