<?php

namespace App\Controller;

use App\Entity\Liker;
use App\Form\LikerType;
use App\Repository\LikerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/liker')]
class LikerController extends AbstractController
{
    #[Route('/', name: 'app_liker_index', methods: ['GET'])]
    public function index(LikerRepository $likerRepository): Response
    {
        return $this->render('liker/index.html.twig', [
            'likers' => $likerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_liker_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $liker = new Liker();
        $form = $this->createForm(LikerType::class, $liker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($liker);
            $entityManager->flush();

            return $this->redirectToRoute('app_liker_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('liker/new.html.twig', [
            'liker' => $liker,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_liker_show', methods: ['GET'])]
    public function show(Liker $liker): Response
    {
        return $this->render('liker/show.html.twig', [
            'liker' => $liker,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_liker_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Liker $liker, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LikerType::class, $liker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_liker_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('liker/edit.html.twig', [
            'liker' => $liker,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_liker_delete', methods: ['POST'])]
    public function delete(Request $request, Liker $liker, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$liker->getId(), $request->request->get('_token'))) {
            $entityManager->remove($liker);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_liker_index', [], Response::HTTP_SEE_OTHER);
    }
}
