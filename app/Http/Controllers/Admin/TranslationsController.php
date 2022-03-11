<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Translations\IndexTranslationRequest;
use App\Http\Requests\Translations\CreateTranslationRequest;
use App\Http\Requests\Translations\MassDestroyTranslationRequest;
use App\Http\Requests\Translations\StoreTranslationRequest;
use App\Http\Requests\Translations\UpdateTranslationRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Translation;
use App\Repositories\TranslationRepository;
use App\Repositories\UserRepository;
use App\Repositories\LanguageRepository;
use App\Repositories\PhraseRepository;

class TranslationsController extends Controller
{
    private $_translationRepository;
    private $_userRepository;
    private $_languageRepository;
    private $_phraseRepository;

    public function __construct(TranslationRepository $translationRepository, UserRepository $userRepository, LanguageRepository $languageRepository, PhraseRepository $phraseRepository)
    {
        $this->_translationRepository = $translationRepository;
        $this->_userRepository = $userRepository;
        $this->_languageRepository = $languageRepository;
        $this->_phraseRepository = $phraseRepository;
    }

    public function index(IndexTranslationRequest $request)
    {
        $translations = $this->_translationRepository->getAllData();

        return view('admin.translations.index', compact('translations'));
    }

    public function create(CreateTranslationRequest $request)
    {
        $authors = $this->_userRepository->getAllData()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $languages = $this->_languageRepository->getAllData()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');
        $phrases = $this->_phraseRepository->getAllData()->pluck('phrase', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.translations.create', compact('authors', 'languages', 'phrases'));
    }

    public function store(StoreTranslationRequest $request)
    {
        $translation = $this->_translationRepository->store($request);

        return redirect()->route('admin.translations.index');
    }

    public function edit(Translation $translation)
    {
        $authors = $this->_userRepository->getAllData()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $languages = $this->_languageRepository->getAllData()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');
        $phrases = $this->_phraseRepository->getAllData()->pluck('phrase', 'id')->prepend(trans('global.pleaseSelect'), '');

        $translation->load('author', 'language', 'phrase');

        return view('admin.translations.edit', compact('authors', 'languages', 'phrases', 'translation'));
    }

    public function update(UpdateTranslationRequest $request, Translation $translation)
    {
        $translation = $this->_translationRepository->update($translation->id, $request);

        return redirect()->route('admin.translations.index');
    }

    public function show(Translation $translation)
    {
        $translation = $this->_translationRepository->view($translation->id);

        return view('admin.translations.show', compact('translation'));
    }

    public function destroy(Translation $translation)
    {
        $translation = $this->_translationRepository->delete($translation->id);

        return back();
    }

    public function massDestroy(MassDestroyTranslationRequest $request)
    {
        $translations = $this->_translationRepository->deleteAll($request('ids'));

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
