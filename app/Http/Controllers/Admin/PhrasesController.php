<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Phrases\IndexPhraseRequest;
use App\Http\Requests\Phrases\CreatePhraseRequest;
use App\Http\Requests\Phrases\MassDestroyPhraseRequest;
use App\Http\Requests\Phrases\StorePhraseRequest;
use App\Http\Requests\Phrases\UpdatePhraseRequest;
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
        $phrases = $this->_phraseRepository->getAllData();

        return view('admin.phrases.index', compact('phrases'));
    }

    public function create(CreatePhraseRequest $request)
    {
        $categories = $this->_categoryRepository->getAllData()->pluck('name','name')->prepend(trans('global.pleaseSelect'), '');
        $phraseCategories = $this->_phraseCategoryRepository->getAllData()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.phrases.create', compact('categories', 'phraseCategories'));
    }

    public function store(StorePhraseRequest $request)
    {
        $phrase = $this->_phraseRepository->store($request);

        return redirect()->route('admin.phrases.index');
    }

    public function edit(Phrase $phrase)
    {
        $categories = $this->_categoryRepository->getAllData()->pluck('name','name')->prepend(trans('global.pleaseSelect'), '');
        $phraseCategories = $this->_phraseCategoryRepository->getAllData()->pluck('name','id')->prepend(trans('global.pleaseSelect'), '');

        $phrase->load('category');
        $phrase->load('phraseCategory');

        return view('admin.phrases.edit', compact('categories', 'phraseCategories', 'phrase'));
    }

    public function update(UpdatePhraseRequest $request, Phrase $phrase)
    {
        $phrase = $this->_phraseRepository->update($phrase->id, $request);

        return redirect()->route('admin.phrases.index');
    }

    public function show(Phrase $phrase)
    {
        $phrase = $this->_phraseRepository->view($phrase->id);

        return view('admin.phrases.show', compact('phrase'));
    }

    public function destroy(Phrase $phrase)
    {
        $phrase = $this->_phraseRepository->delete($phrase->id);

        return back();
    }

    public function massDestroy(MassDestroyPhraseRequest $request)
    {
        $phrases = $this->_phraseRepository->deleteAll($request('ids'));

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
