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
        $pool = Pool::create();

        $pool[] = async(function () {
            return $this->_languageRepository->getAllAsync()->sortBy('id');
        })->then(function ($output) {
            $this->languages=$output;
        });

        $pool[] = async(function () {
            return $this->_categoryRepository->getAllAsync();
        })->then(function ($output) {
            $this->categories=$output;
        });

        await($pool);

        $languages = $this->languages;
        $categories = $this->categories;

        return view('home', compact('languages','categories'));
    }
}
