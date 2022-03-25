<?php
namespace App\Http\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Schema()
 */
class ApiAccessDeniedException extends ApiException
{
    /**
     * The err message
     * @var string
     *
     * @OA\Property(
     *   property="message",
     *   type="string",
     *   example="AccessDenied"
     * )
     */
    public function __construct(string $message = null)
    {
        parent::__construct(
            self::ACCESS_DENIED_ERROR,
            $message ?? Response::$statusTexts[self::ACCESS_DENIED_ERROR]);
    }
}
