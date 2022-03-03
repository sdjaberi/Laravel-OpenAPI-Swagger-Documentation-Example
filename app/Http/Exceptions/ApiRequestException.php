<?php
namespace App\Http\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Schema()
 */
class ApiRequestException extends ApiException
{
    /**
     * The err message
     * @var string
     *
     * @OA\Property(
     *   property="message",
     *   type="string",
     *   example="Bad Request"
     * )
     */
    public function __construct(string $message = null)
    {
        parent::__construct(
            self::BAD_REQUEST,
            $message ?: Response::$statusTexts[self::BAD_REQUEST]);
    }
}
