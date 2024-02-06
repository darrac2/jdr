<?php

namespace App\Controller;

use App\Entity\Forum;
use App\Entity\Likeforum;
use App\Entity\User;
use App\Form\LikeforumType;
use App\Repository\LikeforumRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/likeforum')]
class LikeforumController extends AbstractController
{
    #[Route('/', name: 'app_likeforum_index', methods: ['GET'])]
    public function index(LikeforumRepository $likeforumRepository): Response
    {
        return $this->render('likeforum/index.html.twig', [
            'likeforums' => $likeforumRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_likeforum_new', methods: ['GET'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine)
    {
        $likeforum = new Likeforum();
        $form = $this->createForm(LikeforumType::class, $likeforum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //user 
            $repository = $doctrine->getRepository(User::class);
            $email = $this->getUser()->getUserIdentifier();
            $user = $repository->findOneBy(array('email' => $email));
            $likeforum->setUser($user);
            //set forum 
            $forumid = $request->query->get('idforum');
            //search object forum
            $repository2 = $doctrine->getRepository(Forum::class);
            $forum= $repository2 -> findOneBy(array('id' => $forumid));
            $likeforum->setForum($forum);
            //liker set 1
            $likeforum->setLiker(1);
            $entityManager->persist($likeforum);
            $entityManager->flush();


            
        }

    }

    #[Route('/update/{id}', name: 'app_likeforum_update', methods: ['GET'])]
    public function update(Request $request ,Likeforum $likeforum, EntityManager $entityManager): Response
    {
        
        //set liker update
        $liker = $request->query->get('update');
        //get user
        $user=$this->getUser();
        //verification of the owner of the post 
        if($user != $likeforum->getUser()){
            return $this->json("Vous n'êtes pas l'auteur de ce like ");
        }else{
            $likeforum->setLiker($liker);
            $entityManager->persist($likeforum);
            $entityManager->flush();
            
        }

    }

    #[Route('/{id}', name: 'app_likeforum_show', methods: ['GET'])]
    public function show(Likeforum $likeforum): Response
    {
        return $this->render('likeforum/show.html.twig', [
            'likeforum' => $likeforum,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_likeforum_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Likeforum $likeforum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LikeforumType::class, $likeforum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_likeforum_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('likeforum/edit.html.twig', [
            'likeforum' => $likeforum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_likeforum_delete', methods: ['POST'])]
    public function delete(Request $request, Likeforum $likeforum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$likeforum->getId(), $request->request->get('_token'))) {
            $entityManager->remove($likeforum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_likeforum_index', [], Response::HTTP_SEE_OTHER);
    }
}
