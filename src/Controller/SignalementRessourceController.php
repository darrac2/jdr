<?php

namespace App\Controller;

use App\Entity\Ressource;
use App\Entity\SignalementRessource;
use App\Entity\User;
use App\Form\SignalementRessourceType;
use App\Repository\SignalementRessourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/signalement/ressource')]
class SignalementRessourceController extends AbstractController
{
    #[Route('/', name: 'app_signalement_ressource_index', methods: ['GET'])]
    public function index(SignalementRessourceRepository $signalementRessourceRepository): Response
    {
        return $this->render('signalement_ressource/index.html.twig', [
            'signalement_ressources' => $signalementRessourceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_signalement_ressource_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $signalementRessource = new SignalementRessource();
        $form = $this->createForm(SignalementRessourceType::class, $signalementRessource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //user
            $repository = $doctrine->getRepository(User::class);
            $email = $this->getUser()->getUserIdentifier();
            $user = $repository->findOneBy(array('email' => $email));
            $signalementRessource->setUser($user);
            $id=$request->get("id");
            $repository2= $doctrine->getRepository(Ressource::class);
            $ressource = $repository2->findOneBy(array('id' => $id));
            $signalementRessource->setRessource($ressource);
            $entityManager->persist($signalementRessource);
            $entityManager->flush();

            return $this->redirectToRoute('app_ressource_show', ['id' => $id,], Response::HTTP_SEE_OTHER);
        }

        return $this->render('signalement_ressource/new.html.twig', [
            'signalement_ressource' => $signalementRessource,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_signalement_ressource_show', methods: ['GET'])]
    public function show(SignalementRessource $signalementRessource): Response
    {
        return $this->render('signalement_ressource/show.html.twig', [
            'signalement_ressource' => $signalementRessource,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_signalement_ressource_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SignalementRessource $signalementRessource, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SignalementRessourceType::class, $signalementRessource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_signalement_ressource_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('signalement_ressource/edit.html.twig', [
            'signalement_ressource' => $signalementRessource,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_signalement_ressource_delete', methods: ['POST'])]
    public function delete(Request $request, SignalementRessource $signalementRessource, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$signalementRessource->getId(), $request->request->get('_token'))) {
            $entityManager->remove($signalementRessource);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_signalement_ressource_index', [], Response::HTTP_SEE_OTHER);
    }
}
