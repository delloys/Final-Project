<?php

namespace App\Controller;

use App\Entity\BookStorage;
use App\Form\BookStorageType;
use App\Repository\BookStorageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/book_storage')]
class BookStorageController extends AbstractController
{
    #[Route('/', name: 'app_book_storage_index', methods: ['GET'])]
    public function index(BookStorageRepository $bookStorageRepository): Response
    {
        return $this->render('book_storage/index.html.twig', [
            'book_storages' => $bookStorageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_book_storage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BookStorageRepository $bookStorageRepository): Response
    {
        $bookStorage = new BookStorage();
        $form = $this->createForm(BookStorageType::class, $bookStorage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookStorageRepository->add($bookStorage, true);

            return $this->redirectToRoute('app_book_storage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book_storage/new.html.twig', [
            'book_storage' => $bookStorage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_storage_show', methods: ['GET'])]
    public function show(BookStorage $bookStorage): Response
    {
        return $this->render('book_storage/show.html.twig', [
            'book_storage' => $bookStorage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_book_storage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BookStorage $bookStorage, BookStorageRepository $bookStorageRepository): Response
    {
        $form = $this->createForm(BookStorageType::class, $bookStorage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookStorageRepository->add($bookStorage, true);

            return $this->redirectToRoute('app_book_storage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book_storage/edit.html.twig', [
            'book_storage' => $bookStorage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_storage_delete', methods: ['POST'])]
    public function delete(Request $request, BookStorage $bookStorage, BookStorageRepository $bookStorageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bookStorage->getId(), $request->request->get('_token'))) {
            $bookStorageRepository->remove($bookStorage, true);
        }

        return $this->redirectToRoute('app_book_storage_index', [], Response::HTTP_SEE_OTHER);
    }
}
