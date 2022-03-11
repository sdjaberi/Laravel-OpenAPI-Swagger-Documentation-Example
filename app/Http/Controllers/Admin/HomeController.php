<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\LanguageRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\TranslationRepository;

class HomeController
{
    private $_languageRepository;
    private $_categoryRepository;
    private $_translationRepository;

    public function __construct(LanguageRepository $languageRepository, CategoryRepository $categoryRepository, TranslationRepository $translationRepository)
    {
        $this->_languageRepository = $languageRepository;
        $this->_categoryRepository = $categoryRepository;
        $this->_translationRepository = $translationRepository;
    }

    public function index()
    {
        $languages = $this->_languageRepository->getAllData()->sortBy('id');
        $categories = $this->_categoryRepository->getAllData()->load('phrases');
        $translations = $this->_translationRepository->getAllData();

        return view('home', compact('languages','categories', 'translations'));
    }
}
