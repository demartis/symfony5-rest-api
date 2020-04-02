<?php

namespace App\Controller;

use App\Entity\Book;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Hateoas\HateoasBuilder;
use Hateoas\Serializer\JsonHalSerializer;
use http\Env\Request;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Router;

class BooksController extends AbstractFOSRestController
{

    public function cgetBooksAction(){
        $em = $this->getDoctrine()->getManager();
        $books = $em->getRepository(Book::class)->findAll();

        if (!$books) {
            throw new HttpException(400, "Invalid data");
        }

        $json = HateoasBuilder::create()
            ->setExpressionContextVariable('router', $this->container->get('router'))
            ->setDebug($_SERVER['APP_DEBUG'])
            ->build()
            ->serialize($books, 'json');

        return new Response($json, 200, array('Content-Type' => 'application/json'));
    }

    public function getBookAction($id){
        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository(Book::class)->find($id);

        if (!$book) {
            throw new HttpException(404, "Invalid data");
        }

        $json = HateoasBuilder::create()
            ->setExpressionContextVariable('router', $this->container->get('router'))
            ->setDebug($_SERVER['APP_DEBUG'])
            ->build()
            ->serialize($book, 'json');
        
        return new Response($json, 200, array('Content-Type' => 'application/json'));
    }

}
