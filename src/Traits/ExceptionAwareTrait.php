<?php

namespace App\Traits;

/**
 * (c) Riccardo De Martis <riccardo@demartis.it>
 */
trait ExceptionAwareTrait
{
    /**
     * The exception.
     *
     * @var \Exception
     */
    protected $exception;

    /**
     * Sets exception
     *
     * @param \Exception $exception
     */
    public function setException(\Exception $exception): void
    {
        $this->exception = $exception;
    }
}