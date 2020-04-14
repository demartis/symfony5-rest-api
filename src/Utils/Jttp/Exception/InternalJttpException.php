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
 * InternalJttpException
 *
 * This exception means an HTTP 500 error, but remember your application should avoid it.
 *
*/
class InternalJttpException extends \LogicException implements JttpExceptionInterface
{

}