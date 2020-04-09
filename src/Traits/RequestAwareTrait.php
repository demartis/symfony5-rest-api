<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Request;

/**
 * (c) Riccardo De Martis <riccardo@demartis.it>
 */
trait RequestAwareTrait
{
    /**
     * The request instance.
     *
     * @var Request
     */
    protected $request;

    /**
     * Sets a request.
     *
     * @param Request $request
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }
}