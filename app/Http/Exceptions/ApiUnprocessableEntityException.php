<?php
namespace App\Http\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Schema()
 */
class ApiUnprocessableEntityException extends ApiException
{
    /**
     * The err message
     * @var string
     *
     * @OA\Property(
     *   property="message",
     *   type="string",
     *   example="Unprocessable Entity"
     * )
     */
    public function __construct(string $message = null)
    {
        parent::__construct(
            self::UNPROCESSABLE_ENTITY,
            $message ?: Response::$statusTexts[self::UNPROCESSABLE_ENTITY]);
    }
}
