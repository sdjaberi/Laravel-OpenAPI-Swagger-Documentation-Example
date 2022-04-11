<?php

namespace App\Http\Virtual\Requests;

/**
 * @OA\Schema(
 *      title="Store Translation request",
 *      description="Store Translation request body data",
 *      type="object",
 *      required={"title", "iso_code", "is_primary", "text_direction", "active"}
 * )
 */

class StoreTranslationRequest
{
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
     *      title="PhraseID",
     *      description="Phrase ID",
     *      example="A phrase id"
     * )
     *
     * @var integer
     */
    public $phrase_id;

    /**
     * @OA\Property(
     *      title="LanguageID",
     *      description="Language ID",
     *      example="A language id"
     * )
     *
     * @var integer
     */
    public $language_id;

    /**
     * @OA\Property(
     *      title="UserID",
     *      description="User ID",
     *      example="A user id"
     * )
     *
     * @var integer
     */
    public $user_id;
}
