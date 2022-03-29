<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Phrases\IndexPhraseRequest;
use App\Http\Requests\Web\Phrases\StorePhraseRequest;
use App\Http\Requests\Web\Phrases\UpdatePhraseRequest;
use App\Http\Requests\Web\Phrases\ShowPhraseRequest;
use App\Http\Requests\Web\Phrases\DeletePhraseRequest;
use App\Http\Requests\Web\Phrases\MassDestroyPhraseRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Phrase;
use App\Repositories\PhraseRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\PhraseCategoryRepository;

class PhrasesController extends Controller
{
    private $_phraseRepository;
    private $_categoryRepository;
    private $_phraseCategoryRepository;

    public function __construct(
        PhraseRepository $phraseRepository,
        CategoryRepository $categoryRepository,
        PhraseCategoryRepository $phraseCategoryRepository)
    {
        $this->_phraseRepository = $phraseRepository;
        $this->_categoryRepository = $categoryRepository;
        $this->_phraseCategoryRepository = $phraseCategoryRepository;
    }

    public function index(IndexPhraseRequest $request)
    {
        $phrases = $this->_phraseRepository->getAllWithCategory();

        return view('admin.phrases.index', compact('phrases'));
    }

    public function create()
    {
        $categories = $this->_categoryRepository->getAllAsync()->pluck('name','name')->prepend(trans('global.pleaseSelect'), '');
        $phraseCategories = $this->_phraseCategoryRepository->getAllAsync()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.phrases.create', compact('categories', 'phraseCategories'));
    }

    public function store(StorePhraseRequest $request)
    {
        $phrase = $this->_phraseRepository->storeAsync($request->all());

        return redirect()->route('admin.phrases.index');
    }

    public function edit(Phrase $phrase)
    {
        $categories = $this->_categoryRepository->getAllAsync()->pluck('name','name')->prepend(trans('global.pleaseSelect'), '');
        $phraseCategories = $this->_phraseCategoryRepository->getAllAsync()->pluck('name','id')->prepend(trans('global.pleaseSelect'), '');

        $phrase->load('category');
        $phrase->load('phraseCategory');

        return view('admin.phrases.edit', compact('categories', 'phraseCategories', 'phrase'));
    }

    public function update(UpdatePhraseRequest $request, Phrase $phrase)
    {
        $result = $this->_phraseRepository->updateAsync($phrase->id, $request->all());

        return redirect()->route('admin.phrases.index');
    }

    public function show(ShowPhraseRequest $request, Phrase $phrase)
    {
        $phrase = $this->_phraseRepository->viewAsync($phrase->id);

        return view('admin.phrases.show', compact('phrase'));
    }

    public function destroy(DeletePhraseRequest $request, Phrase $phrase)
    {
        $phrase = $this->_phraseRepository->deleteAsync($phrase->id);

        return back();
    }

    public function massDestroy(MassDestroyPhraseRequest $request)
    {
        $phrases = $this->_phraseRepository->deleteAllAsync($request->ids);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
