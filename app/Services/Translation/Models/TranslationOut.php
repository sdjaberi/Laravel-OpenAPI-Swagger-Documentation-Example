<?php

namespace App\Services\Translation\Models;

use App\Services\Base\IDto;

/**
 * @OA\Schema(
 *     title="TranslationOut",
 *     description="TranslationOut model",
 *     @OA\Xml(
 *         name="TranslationOut"
 *     )
 * )
 */
class TranslationOut extends IDto
{
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    public $id;

    /**
     * @OA\Property(
     *      title="Translation",
     *      description="Translation",
     *      example="A new translation"
     * )
     *
     * @var string
     */
    public $translation;

    /**
     * @OA\Property(
     *     title="Phrase ID",
     *     description="Phrase ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    public $phrase_id;

    /**
     * @OA\Property(
     *     title="Language ID",
     *     description="Language ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    public $language_id;

    /**
     * @OA\Property(
     *     title="User ID",
     *     description="User ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    public $user_id;



    /************************* Models **********************/
    /**
     * @OA\Property(
     *      title="Language",
     *      description="Language Model",
     * )
     *
     * @var \App\Services\Language\Models\LanguageOut
     */
    public $language;

    /**
     * @OA\Property(
     *      title="Phrase",
     *      description="Phrase Model",
     * )
     *
     * @var \App\Services\Phrase\Models\PhraseOut
     */
    public $phrase;

    /**
     * @OA\Property(
     *      title="User",
     *      description="User Model",
     * )
     *
     * @var \App\Services\User\Models\UserOut
     */
    public $user;
}
