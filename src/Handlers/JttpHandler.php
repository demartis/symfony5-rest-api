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

namespace App\Handlers;

use App\Utils\Jttp\Jttp;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JttpHandler
{
    use LoggerAwareTrait;

    public function __construct(LoggerInterface $logger)
    {
        $this->setLogger($logger);
    }

    public function createResponse(ViewHandler $handler, View $view, Request $request, string $format):Response
    {
        if($this->isSuccessful($view))  {

            $response = $handler->createResponse($view, $request, 'json');
            $content = $response->getContent();
            $jttpContent = Jttp::success(json_decode($content, true))->toJson();

        }else{
            $errorContent=[];
            if(method_exists($view->getData(), 'getMessage')){

                $errorContent["details"] = $view->getData()->getMessage();
            }else{
                $errorContent["details"] = $view->getData();
            }
            $jttpContent = Jttp::error($view->getStatusCode(), null, $errorContent )->toJson();
            $response = new Response($jttpContent, $view->getStatusCode(), $view->getHeaders());
        }

        $response->setContent($jttpContent);
        return $response;
    }

    private function isSuccessful(View $view): bool
    {
        return $view->getStatusCode() >= 200 && $view->getStatusCode() < 300;
    }
}