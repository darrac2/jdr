<?php

namespace App\Controller;

use App\Entity\ForumCommentaire;
use App\Entity\User;
use App\Entity\Forum;
use App\Form\ForumCommentaireType;
use App\Repository\ForumCommentaireRepository;
use App\Repository\LikeforumRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/forum/commentaire')]
class ForumCommentaireController extends AbstractController
{
    #[Route('/', name: 'app_forum_commentaire_index', methods: ['GET'])]
    public function index(ForumCommentaireRepository $forumCommentaireRepository): Response
    {
        return $this->render('forum_commentaire/index.html.twig', [
            'forum_commentaires' => $forumCommentaireRepository->findAll(),
        ]);
    }
    #[Route('/forumindex', name: 'app_forum_commentaire_forumindex', methods: ['GET', 'POST'])]
    public function forumindex(  ManagerRegistry $doctrine, int $id): Response
    {
       //commentaire afficher
        $forums = $doctrine->getRepository(ForumCommentaire::class)->findBy(["idForum" => $id]);
        return $this->render('forum/_index.html.twig', [
            'forum_commentaires' => $forums,
        ]);
    }
    

    #[Route('/new', name: 'app_forum_commentaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
        $forumCommentaire = new ForumCommentaire();
        $form = $this->createForm(ForumCommentaireType::class, $forumCommentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

            return $this->redirectToRoute('app_forum_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('forum_commentaire/new.html.twig', [
            'forum_commentaire' => $forumCommentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_forum_commentaire_show', methods: ['GET'])]
    public function show(ForumCommentaire $forumCommentaire): Response
    {
        return $this->render('forum_commentaire/show.html.twig', [
            'forum_commentaire' => $forumCommentaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_forum_commentaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ForumCommentaire $forumCommentaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ForumCommentaireType::class, $forumCommentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_forum_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('forum_commentaire/edit.html.twig', [
            'forum_commentaire' => $forumCommentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_forum_commentaire_delete', methods: ['POST'])]
    public function delete(Request $request, ForumCommentaire $forumCommentaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$forumCommentaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($forumCommentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_forum_commentaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
