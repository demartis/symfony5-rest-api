<?php
/**
 *
 * This file is part of a repository on GitHub.
 *
 * (c) Riccardo De Martis <riccardo@demartis.it>
 *
 * <https://github.com/demartis>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace App\Utils\Jttp;

use Symfony\Component\HttpFoundation\Response;

class HttpUtils
{
    static function getStatusCode200(): int {
        return Response::HTTP_OK;
    }

    static function getHttpStatus($httpCode): string {

        return isset(Response::$statusTexts[$httpCode])?Response::$statusTexts[$httpCode]:'';
    }
}