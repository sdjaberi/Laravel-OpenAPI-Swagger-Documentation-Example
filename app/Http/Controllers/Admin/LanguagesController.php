<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Languages\IndexLanguageRequest;
use App\Http\Requests\Languages\CreateLanguageRequest;
use App\Http\Requests\Languages\MassDestroyLanguageRequest;
use App\Http\Requests\Languages\StoreLanguageRequest;
use App\Http\Requests\Languages\UpdateLanguageRequest;
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
        $languages = $this->_languageRepository->getAllData();

        return view('admin.languages.index', compact('languages'));
    }

    public function create(CreateLanguageRequest $request)
    {
        $text_directions = (object) array("ltr","rtl");

        //dd($text_direction);

        return view('admin.languages.create', compact('text_directions'));
    }

    public function store(StoreLanguageRequest $request)
    {
        //dd($request->all());

        $language = $this->_languageRepository->store($request);

        return redirect()->route('admin.languages.index');
    }

    public function edit(Language $language)
    {
        $text_directions = (object) array("ltr","rtl");

        return view('admin.languages.edit', compact('text_directions', 'language'));
    }

    public function update(UpdateLanguageRequest $request, Language $language)
    {
        //dd($request->all());

        $language = $this->_languageRepository->update($language->id, $request);

        return redirect()->route('admin.languages.index');
    }

    public function show(Language $language)
    {
        $language = $this->_languageRepository->view($language->id);

        $language->load('projects');
        $language->load('users');

        return view('admin.languages.show', compact('language'));
    }

    public function destroy(Language $language)
    {
        $language = $this->_languageRepository->delete($language->id);

        return back();
    }

    public function massDestroy(MassDestroyLanguageRequest $request)
    {
        $languages = $this->_languageRepository->deleteAll(request('ids'));

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
