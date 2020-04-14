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

namespace App\Controller;

use App\Entity\Book;
use App\Exception\FormException;
use App\Form\BookType;
use FOS\RestBundle\Controller\AbstractFOSRestController;

use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;

use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class BookController extends AbstractFOSRestController
{

    public function cgetBooksAction(){
        $em = $this->getDoctrine()->getManager();
        $books = $em->getRepository(Book::class)->findAll();
        $view = $this->view($books, Response::HTTP_OK , []);
        return $this->handleView($view);
    }

    public function getBookAction($id){
        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository(Book::class)->find($id);

        if (!$book) {
            // throw new HttpException(404, "Resource $id not found");
            throw new ResourceNotFoundException( "Resource $id not found");
        }

        $view = $this->view($book, Response::HTTP_OK , []);
        return $this->handleView($view);
    }

    /**
     *
     * @RequestParam(name="data", nullable=false)
     *
     * @param Request $request
     * @param ParamFetcher $paramFetcher
     *
     * @throws \Exception
     * @return Response
     *
     */
    public function postBookAction(Request $request, ParamFetcher $paramFetcher){

        $book = new Book();

        $form = $this->createForm(BookType::class, $book);
        $requestBody=$paramFetcher->get('data');

        $form->submit($requestBody);

        if ($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();

            $em->persist($book);
            $em->flush();

            $view = $this->view($book, Response::HTTP_OK);
            return $this->handleView($view);

        } else {

            throw new FormException($form);
        }

    }
}
