<?php

namespace App\Repositories;

use App\Models\Phrase;
use Illuminate\Support\Facades\Gate;
use App\Http\Exceptions\ApiNotFoundException;
use App\Http\Exceptions\ApiPermissionException;
use Barryvdh\Debugbar\Facades\Debugbar;
use Barryvdh\Debugbar\Middleware\DebugbarEnabled;

interface IPhraseRepository
{
    public function getAllData();
    public function store($data);
    public function update($id = null,$data);
    public function view($id);
    public function delete($id);
    public function deleteAll($ids);
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
        $phrase->base_id = $data['base_id'];
        $phrase->phrase = $data['phrase'];
        $phrase->category_name = $data['category_name'];
        $phrase->save();

        return $phrase;
    }

    public function update($id = null, $data)
    {
        $phrase = Phrase::find($id);

        if(!$phrase)
            throw new ApiNotFoundException();

        $phrase->base_id = $data['base_id'];
        $phrase->phrase = $data['phrase'];
        $phrase->category_name = $data['category_name'];
        $phrase->save();

        return $phrase;
    }

    public function view($id)
    {
        return Phrase::find($id)->load('category');
    }

    public function delete($id)
    {
        return Phrase::find($id)->delete();
    }

    public function deleteAll($ids)
    {
        return Phrase::whereIn('id', $ids)->delete();
    }

}
