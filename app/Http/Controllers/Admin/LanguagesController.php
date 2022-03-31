<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Web\Languages\IndexLanguageRequest;
use App\Http\Requests\Web\Languages\StoreLanguageRequest;
use App\Http\Requests\Web\Languages\UpdateLanguageRequest;
use App\Http\Requests\Web\Languages\ShowLanguageRequest;
use App\Http\Requests\Web\Languages\DeleteLanguageRequest;
use App\Http\Requests\Web\Languages\MassDestroyLanguageRequest;
use App\Http\Controllers\Controller;
use App\Repositories\LanguageRepository;

class LanguagesController extends Controller
{
    private $_languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->_languageRepository = $languageRepository;
    }

    public function index(IndexLanguageRequest $request)
    {
        $languages = $this->_languageRepository->getAllAsync()->get();

        return view('admin.languages.index', compact('languages'));
    }

    public function create()
    {
        $text_directions = (object) array("ltr","rtl");

        return view('admin.languages.create', compact('text_directions'));
    }

    public function store(StoreLanguageRequest $request)
    {
        $attributes = $request->all();

        if(array_key_exists('is_primary', $attributes))
            $attributes['is_primary'] = 1;
        else
            $attributes['is_primary'] = 0;

        if(array_key_exists('active', $attributes))
            $attributes['active'] = 1;
        else
            $attributes['active'] = 0;

        $language = $this->_languageRepository->storeAsync($attributes);

        return redirect()->route('admin.languages.index');
    }

    public function edit(Language $language)
    {
        $text_directions = (object) array("ltr","rtl");

        return view('admin.languages.edit', compact('text_directions', 'language'));
    }

    public function update(UpdateLanguageRequest $request, Language $language)
    {
        $attributes = $request->all();

        if(isset($request->is_primary) && $request->is_primary == "on")
            $attributes['is_primary'] = 1;
        else
            $attributes['is_primary'] = 0;

        if(isset($request->active) && $request->active == "on")
            $attributes['active'] = 1;
        else
            $attributes['active'] = 0;

        $result = $this->_languageRepository->updateAsync($language->id, $attributes);

        return redirect()->route('admin.languages.index');
    }

    public function show(ShowLanguageRequest $request, Language $language)
    {
        $language = $this->_languageRepository->viewAsync($language->id);

        $language->load('projects');
        $language->load('users');

        return view('admin.languages.show', compact('language'));
    }

    public function destroy(DeleteLanguageRequest $request, Language $language)
    {
        $result = $this->_languageRepository->deleteAsync($language->id);

        return back();
    }

    public function massDestroy(MassDestroyLanguageRequest $request)
    {
        $result = $this->_languageRepository->deleteAllAsync($request->ids);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
