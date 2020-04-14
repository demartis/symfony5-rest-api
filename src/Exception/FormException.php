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

namespace App\Exception;


use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FormException extends HttpException
{
    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * HttpFormException constructor.
     *
     * @param FormInterface   $form
     * @param int             $statusCode
     * @param string|null     $message
     * @param \Exception|null $previous
     * @param array           $headers
     * @param int|null        $code
     */
    public function __construct(FormInterface $form, int $statusCode = 400, string $message = null, \Exception $previous = null, array $headers = [], ?int $code = 0)
    {
        parent::__construct($statusCode, $message, $previous, $headers, $code);

        $this->form = $form;
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @return FormErrorIterator
     */
    public function getErrors()
    {
        return $this->form->getErrors(true);
    }
}