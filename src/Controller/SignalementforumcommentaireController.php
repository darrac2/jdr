<?php

namespace App\Controller;

use App\Entity\ForumCommentaire;
use App\Entity\Signalementforumcommentaire;
use App\Entity\User;
use App\Form\SignalementforumcommentaireType;
use App\Repository\SignalementforumcommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/signalementforumcommentaire')]
class SignalementforumcommentaireController extends AbstractController
{
    #[Route('/', name: 'app_signalementforumcommentaire_index', methods: ['GET'])]
    public function index(SignalementforumcommentaireRepository $signalementforumcommentaireRepository): Response
    {
        return $this->render('signalementforumcommentaire/index.html.twig', [
            'signalementforumcommentaires' => $signalementforumcommentaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_signalementforumcommentaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $signalementforumcommentaire = new Signalementforumcommentaire();
        $form = $this->createForm(SignalementforumcommentaireType::class, $signalementforumcommentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //get forumcommanetaire from id
            $forumcomid = $request->query->get('id');
            $repository3 = $doctrine->getRepository(ForumCommentaire::class);
            $forumcommentaire = $repository3->findOneBy(array('id' => $forumcomid));
            $signalementforumcommentaire->setForumcommentaire($forumcommentaire);
            //user
            $repository = $doctrine->getRepository(User::class);
            $email = $this->getUser()->getUserIdentifier();
            $user = $repository->findOneBy(array('email' => $email));
            $signalementforumcommentaire->setUser($user);
            //forum commentaire
            $id=$request->attributes->get("idforumcom");
            $repository2= $doctrine->getRepository(ForumCommentaire::class);
            $forumcommentaire = $repository2->findOneBy(array('id' => $id));
            $signalementforumcommentaire->setForumcommentaire($forumcommentaire);


            $entityManager->persist($signalementforumcommentaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_signalementforumcommentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('signalementforumcommentaire/new.html.twig', [
            'signalementforumcommentaire' => $signalementforumcommentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_signalementforumcommentaire_show', methods: ['GET'])]
    public function show(Signalementforumcommentaire $signalementforumcommentaire): Response
    {
        return $this->render('signalementforumcommentaire/show.html.twig', [
            'signalementforumcommentaire' => $signalementforumcommentaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_signalementforumcommentaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Signalementforumcommentaire $signalementforumcommentaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SignalementforumcommentaireType::class, $signalementforumcommentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_signalementforumcommentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('signalementforumcommentaire/edit.html.twig', [
            'signalementforumcommentaire' => $signalementforumcommentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_signalementforumcommentaire_delete', methods: ['POST'])]
    public function delete(Request $request, Signalementforumcommentaire $signalementforumcommentaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$signalementforumcommentaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($signalementforumcommentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_signalementforumcommentaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
