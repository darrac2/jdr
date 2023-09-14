<?php

namespace App\Controller;

use App\Entity\Forum;
use App\Entity\User;
use App\Form\ForumType;
use App\Repository\ForumCommentaireRepository;
use App\Repository\ForumRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ForumCommentaire;
use App\Form\ForumCommentaireType;


#[Route('/forum')]
class ForumController extends AbstractController
{
    #[Route('/', name: 'app_forum_index', methods: ['GET', 'POST'])]
    public function index(ForumRepository $forumRepository,ManagerRegistry $doctrine, Request $request, EntityManagerInterface $entityManager): Response
    {
        $forum = new Forum();
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //date
            $date = new DateTime('now');
            $forum->setDateCrea($date);
            //user 
            $repository = $doctrine->getRepository(User::class);
            $email = $this->getUser()->getUserIdentifier();
            $user = $repository->findOneBy(array('email' => $email));
            $forum->setUser($user);
            $forum->setOrdre(0);

            $entityManager->persist($forum);
            $entityManager->flush();

            return $this->redirectToRoute('app_forum_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('forum/index.html.twig', [
            'forums' => $forumRepository->findAll(),
            'forum' => $forum,
            'form' => $form,
        ]);
        
        
        /*return $this->render('forum/index.html.twig', [
            'forums' => $forumRepository->findAll(),
        ]);*/
    }

    #[Route('/new', name: 'app_forum_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $forum = new Forum();
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //date
            $date = new DateTime('now');
            $forum->setDateCrea($date);
            //user 
            $repository = $doctrine->getRepository(User::class);
            $email = $this->getUser()->getUserIdentifier();
            $user = $repository->findOneBy(array('email' => $email));
            $forum->setUser($user);
            $forum->setOrdre(0);

            $entityManager->persist($forum);
            $entityManager->flush();

            return $this->redirectToRoute('app_forum_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('forum/new.html.twig', [
            'forum' => $forum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_forum_show', methods: ['GET', 'POST'])]
    public function show( ManagerRegistry $doctrine, Request $request, EntityManagerInterface $entityManager, Forum $forum): Response
    {   
        //formulaire
        $forumCommentaire = new ForumCommentaire();
        $form = $this->createForm(ForumCommentaireType::class, $forumCommentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // set forum
            $forumCommentaire->setIdForum($forum);
            // set user 
            //user 
            $repository = $doctrine->getRepository(User::class);
            $email = $this->getUser()->getUserIdentifier();
            $user = $repository->findOneBy(array('email' => $email));
            $forumCommentaire->setUser($user);
            //set date
            $date = new DateTime('now');
            $forumCommentaire->setDateCreation($date);

            $entityManager->persist($forumCommentaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_forum_show', [
                'id' => $forum->getId(),
                'forum' => $forum,
                'form' => $form,
            ], Response::HTTP_SEE_OTHER);
        }
        return $this->render('forum/show.html.twig', [
            'forum' => $forum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_forum_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Forum $forum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_forum_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('forum/edit.html.twig', [
            'forum' => $forum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_forum_delete', methods: ['POST'])]
    public function delete(Request $request, Forum $forum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$forum->getId(), $request->request->get('_token'))) {
            $entityManager->remove($forum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_forum_index', [], Response::HTTP_SEE_OTHER);
    }
}
