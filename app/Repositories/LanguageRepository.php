<?php

namespace App\Repositories;

use App\Models\Language;
use App\Http\Exceptions\ApiNotFoundException;
use Spatie\Async\Pool;

interface ILanguageRepository
{
    public function getAllAsync();
    public function getAllNotPrimaryAsync();
    public function getAllActiveAsync();
    public function getPrimaryAsync();
    public function storeAsync($data);
    public function updateAsync($id = null,$data);
    public function viewAsync($id);
    public function deleteAsync($id);
    public function deleteAllAsync($ids);
}

class LanguageRepository implements ILanguageRepository
{
    public function getAllAsync()
    {
        $pool = Pool::create();
        $pool[] = async(function () {
            return Language::all();
        })->then(function ($output) {
            $this->languages = $output;
        });
        await($pool);

        return $this->languages;
    }

    public function getAllNotPrimaryAsync()
    {
        $pool = Pool::create();
        $pool[] = async(function () {
            return Language::where('is_primary', 0);
        })->then(function ($output) {
            $this->languages = $output;
        });
        await($pool);

        return $this->languages;
    }

    public function getAllActiveAsync()
    {
        $pool = Pool::create();
        $pool[] = async(function () {
            return Language::where('active', 1);
        })->then(function ($output) {
            $this->languages = $output;
        });
        await($pool);

        return $this->languages;
    }

    public function getPrimaryAsync()
    {
        $pool = Pool::create();
        $pool[] = async(function () {
            return Language::where('is_primary', 1)->first();
        })->then(function ($output) {
            $this->language = $output;
        });
        await($pool);

        return $this->language;
    }

    public function storeAsync($data)
    {
        $language = new Language();

        $language->title = $data['title'];
        $language->iso_code = $data['iso_code'];
        $language->local_name = $data['local_name'];
        $language->text_direction = $data['text_direction'];
        $language->active = !$data['active'] ? 1 : 0;
        $language->is_primary = $data['is_primary'] ? 1 : 0;

        $pool = Pool::create();
        $pool[] = async(function () use($language) {
            $language->save();;
        })->then(function ($output) {
            $this->language = $output;
        });
        await($pool);

        return $this->language;
    }

    public function updateAsync($id = null, $data)
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

        $pool = Pool::create();
        $pool[] = async(function () use($language) {
            $language->save();
        })->then(function ($output) {
            $this->language = $output;
        });
        await($pool);

        return $this->language;
    }

    public function viewAsync($id)
    {
        $pool = Pool::create();
        $pool[] = async(function () use($id) {
            return Language::find($id);
        })->then(function ($output) {
            $this->language = $output;
        });
        await($pool);

        return $this->language;
    }

    public function deleteAsync($id)
    {
        $pool = Pool::create();
        $pool[] = async(function () use($id) {
            return Language::find($id)->delete();
        })->then(function ($output) {
            $this->language = $output;
        });
        await($pool);

        return $this->language;
    }

    public function deleteAllAsync($ids)
    {
        $pool = Pool::create();
        $pool[] = async(function () use($ids) {
            return Language::whereIn('id', $ids)->delete();
        })->then(function ($output) {
            $this->languages = $output;
        });
        await($pool);

        return $this->languages;
    }
}
