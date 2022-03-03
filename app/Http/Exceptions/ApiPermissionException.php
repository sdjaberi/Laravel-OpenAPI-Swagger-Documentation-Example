<?php
namespace App\Http\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Schema()
 */
class ApiPermissionException extends ApiException
{
    /**
     * The err message
     * @var string
     *
     * @OA\Property(
     *   property="message",
     *   type="string",
     *   example="NoPermission"
     * )
     */
    public function __construct(string $message = null)
    {
        parent::__construct(
            self::PERMISSION_ERROR,
            $message ?? Response::$statusTexts[self::PERMISSION_ERROR]);
    }
}
