<?php


namespace App\Listener;


use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class ViewResponseListener
{

    use LoggerAwareTrait;

    /**
     * Renders the parameters and template and initializes a new response object with the
     * rendered content.
     *
     * @param ViewEvent $event
     * @return array|mixed
     */
    public function onKernelView(ViewEvent $event)
    {
        $request = $event->getRequest();
       $response = new Response();
        $event->setResponse($response);
    }

}