<?php

namespace App\Controller;

use App\Entity\BookEdition;
use App\Form\BookEditionType;
use App\Repository\BookEditionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/book_edition')]
class BookEditionController extends AbstractController
{
    #[Route('/', name: 'app_book_edition_index', methods: ['GET'])]
    public function index(BookEditionRepository $bookEditionRepository): Response
    {
        return $this->render('book_edition/index.html.twig', [
            'book_editions' => $bookEditionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_book_edition_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BookEditionRepository $bookEditionRepository): Response
    {
        $bookEdition = new BookEdition();
        $form = $this->createForm(BookEditionType::class, $bookEdition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookEditionRepository->add($bookEdition, true);

            return $this->redirectToRoute('app_book_edition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book_edition/new.html.twig', [
            'book_edition' => $bookEdition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_edition_show', methods: ['GET'])]
    public function show(BookEdition $bookEdition): Response
    {
        return $this->render('book_edition/show.html.twig', [
            'book_edition' => $bookEdition,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_book_edition_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BookEdition $bookEdition, BookEditionRepository $bookEditionRepository): Response
    {
        $form = $this->createForm(BookEditionType::class, $bookEdition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookEditionRepository->add($bookEdition, true);

            return $this->redirectToRoute('app_book_edition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book_edition/edit.html.twig', [
            'book_edition' => $bookEdition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_edition_delete', methods: ['POST'])]
    public function delete(Request $request, BookEdition $bookEdition, BookEditionRepository $bookEditionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bookEdition->getId(), $request->request->get('_token'))) {
            $bookEditionRepository->remove($bookEdition, true);
        }

        return $this->redirectToRoute('app_book_edition_index', [], Response::HTTP_SEE_OTHER);
    }
}
