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

namespace App\Listener;

use App\Utils\Jttp\Jttp;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\Response;


/**
 * Description of ExceptionListener
 *
 * @author Riccardo De Martis <riccardo@demartis.it>
 */
class ExceptionListener
{
    use LoggerAwareTrait;

    public function onKernelException(ExceptionEvent $event)
    {
        $throwable = $event->getThrowable();
        $type = get_class($throwable);

        if(method_exists($throwable, 'getStatusCode')){
            $statusCode = $throwable->getStatusCode();
        }else{
            switch ($type){
                case 'Symfony\Component\Routing\Exception\ResourceNotFoundException':
                    $statusCode = Response::HTTP_NOT_FOUND;
                    break;

                case 'Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException':
                    $statusCode = Response::HTTP_NOT_IMPLEMENTED;
                    break;

                default:
                    $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                    break;
            }
        }

        $error=[];
        switch ($type){

            case 'App\Exception\FormException':
                $data=[];
                /** @var FormErrorIterator $errors */
                $errors = $throwable->getErrors();
                foreach ($errors as $e) {
                    $data[$e->getOrigin()->getName()] = $e->getMessage();
                }
                $error['form']=$data;
                break;

            default:
                $message=$throwable->getMessage();
                if(gettype($message)=='string' ){
                    $error['detail']=$message;
                }else{
                    $error=$message;
                }
                break;
        }


        $content=Jttp::error($statusCode, null, $error)->toArray();

        $response = new Response();
        $response->setStatusCode($statusCode);
        $response->headers->set('Content-Type', 'application/json');
        $jsonContent = json_encode($content);

        if (json_last_error() != JSON_ERROR_NONE) {
            $jsonContent = "['error converting to json: ".json_last_error_msg()."']";
        }
        $response->setContent($jsonContent);
        $event->setResponse($response);
    }
//
//    /**
//     * Creates the ApiResponse from any Exception
//     *
//     * @param \Throwable $exception
//     *
//     * @return ApiResponse
//     */
//    private function createApiResponse(\Exception $exception)
//    {
//        $statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
//        $errors = [];
//
//        return new ApiResponse($exception->getMessage(), null, $errors, $statusCode);
//    }
}