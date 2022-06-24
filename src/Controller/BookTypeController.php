<?php

namespace App\Controller;

use App\Entity\BookType;
use App\Form\BookTypeType;
use App\Repository\BookTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/book_type')]
class BookTypeController extends AbstractController
{
    #[Route('/', name: 'app_book_type_index', methods: ['GET'])]
    public function index(BookTypeRepository $bookTypeRepository): Response
    {
        return $this->render('book_type/index.html.twig', [
            'book_types' => $bookTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_book_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BookTypeRepository $bookTypeRepository): Response
    {
        $bookType = new BookType();
        $form = $this->createForm(BookTypeType::class, $bookType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookTypeRepository->add($bookType, true);

            return $this->redirectToRoute('app_book_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book_type/new.html.twig', [
            'book_type' => $bookType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_type_show', methods: ['GET'])]
    public function show(BookType $bookType): Response
    {
        return $this->render('book_type/show.html.twig', [
            'book_type' => $bookType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_book_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BookType $bookType, BookTypeRepository $bookTypeRepository): Response
    {
        $form = $this->createForm(BookTypeType::class, $bookType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookTypeRepository->add($bookType, true);

            return $this->redirectToRoute('app_book_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book_type/edit.html.twig', [
            'book_type' => $bookType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_type_delete', methods: ['POST'])]
    public function delete(Request $request, BookType $bookType, BookTypeRepository $bookTypeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bookType->getId(), $request->request->get('_token'))) {
            $bookTypeRepository->remove($bookType, true);
        }

        return $this->redirectToRoute('app_book_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
