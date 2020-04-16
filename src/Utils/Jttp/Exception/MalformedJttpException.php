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

namespace App\Utils\Jttp\Exception;

/**
 * MalformedJttpException
 *
 * This exception should trigger an HTTP 400 response in your application code.
 *
*/
class MalformedJttpException extends \LogicException implements JttpExceptionInterface
{

}