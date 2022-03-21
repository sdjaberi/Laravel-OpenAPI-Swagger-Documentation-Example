<?php
namespace App\Http\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Schema()
 */
class ApiUnAuthException extends ApiException
{
    /**
     * The err message
     * @var string
     *
     * @OA\Property(
     *   property="message",
     *   type="string",
     *   example="Unauthenticated"
     * )
     */
    public function __construct(string $message = null)
    {
        parent::__construct(
            self::AUTH_ERROR,
            $message ?? Response::$statusTexts[self::AUTH_ERROR]);
    }
}
