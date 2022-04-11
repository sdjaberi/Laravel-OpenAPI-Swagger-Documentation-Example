<?php

namespace App\Http\Virtual\Requests;

/**
 * @OA\Schema(
 *      title="Update Translation request",
 *      description="Update Translation request body data",
 *      type="object",
 *      required={"id", "iso_code", "is_primary", "text_direction", "active"}
 * )
 */

class UpdateTranslationRequest
{
        /**
     * @OA\Property(
     *      title="Id",
     *      description="Id",
     *      format="int64",
     *      example=1
     * )
     *
     * @var integer
     */
    private $id;

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
