<?php

namespace App\Http\Controllers\Admin;

use App\Models\Phrase;
use App\Models\Translation;
use Illuminate\Support\Facades\DB;
use App\Repositories\LanguageRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\PhraseRepository;
use App\Repositories\TranslationRepository;

class HomeController
{
    private $_languageRepository;
    private $_categoryRepository;
    private $_phraseRepository;
    private $_translationRepository;

    public function __construct(
        LanguageRepository $languageRepository,
        CategoryRepository $categoryRepository,
        PhraseRepository $phraseRepository,
        TranslationRepository $translationRepository)
    {
        $this->_languageRepository = $languageRepository;
        $this->_categoryRepository = $categoryRepository;
        $this->_phraseRepository = $phraseRepository;
        $this->_translationRepository = $translationRepository;
    }

    public function index()
    {
        $languages = $this->_languageRepository->getAllData()->sortBy('id');
        $categories = $this->_categoryRepository->getAllData();
        $phrases = Phrase::select('id', 'category_name')->get();
        $translations = DB::table('phrase_translations')
            ->join('phrases', 'phrase_translations.phrase_id', '=', 'phrases.id')
            ->select('phrase_translations.id', 'phrase_translations.language_id', 'phrases.category_name')
            ->get();

        return view('home', compact('languages','categories', 'phrases', 'translations'));
    }
}
