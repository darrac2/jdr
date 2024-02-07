<?php

namespace App\Controller;

use App\Entity\Forum;
use App\Entity\Signalementforum;
use App\Entity\User;
use App\Form\SignalementforumType;
use App\Repository\SignalementforumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/signalementforum')]
class SignalementforumController extends AbstractController
{
    #[Route('/', name: 'app_signalementforum_index', methods: ['GET'])]
    public function index(SignalementforumRepository $signalementforumRepository): Response
    {
        return $this->render('signalementforum/index.html.twig', [
            'signalementforums' => $signalementforumRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_signalementforum_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $signalementforum = new Signalementforum();
        $form = $this->createForm(SignalementforumType::class, $signalementforum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //user
            $repository = $doctrine->getRepository(User::class);
            $email = $this->getUser()->getUserIdentifier();
            $user = $repository->findOneBy(array('email' => $email));
            $signalementforum->setUser($user);
            $id=$request->attributes->get("idforumcom");
            $repository2= $doctrine->getRepository(Forum::class);
            $forum = $repository2->findOneBy(array('id' => $id));
            $signalementforum->setForum($forum);

            $entityManager->persist($signalementforum);
            $entityManager->flush();

            return $this->redirectToRoute('app_signalementforum_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('signalementforum/new.html.twig', [
            'signalementforum' => $signalementforum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_signalementforum_show', methods: ['GET'])]
    public function show(Signalementforum $signalementforum): Response
    {
        return $this->render('signalementforum/show.html.twig', [
            'signalementforum' => $signalementforum,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_signalementforum_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Signalementforum $signalementforum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SignalementforumType::class, $signalementforum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_signalementforum_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('signalementforum/edit.html.twig', [
            'signalementforum' => $signalementforum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_signalementforum_delete', methods: ['POST'])]
    public function delete(Request $request, Signalementforum $signalementforum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$signalementforum->getId(), $request->request->get('_token'))) {
            $entityManager->remove($signalementforum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_signalementforum_index', [], Response::HTTP_SEE_OTHER);
    }
}
