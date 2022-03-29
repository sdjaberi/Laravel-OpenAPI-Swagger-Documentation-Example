<?php

namespace App\Http\Controllers\Admin;

use App\Models\Phrase;
use App\Models\Translation;
use Illuminate\Support\Facades\DB;
use App\Repositories\LanguageRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\PhraseRepository;
use App\Repositories\TranslationRepository;
use Spatie\Async\Pool;

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
        $languages = $this->_languageRepository->getAllAsync()->sortBy('id');
        $categories = $this->_categoryRepository->getAllAsync();

        return view('home', compact('languages','categories'));
    }
}
