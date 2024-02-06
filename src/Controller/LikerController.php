<?php

namespace App\Controller;

use App\Entity\Liker;
use App\Entity\Ressource;
use App\Entity\User;
use App\Form\LikerType;
use App\Repository\LikerRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
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

    #[Route('/new', name: 'app_liker_new', methods: ['GET'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine)
    {
        $liker = new Liker();
        $form = $this->createForm(LikerType::class, $liker);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            //user 
            $repository = $doctrine->getRepository(User::class);
            $email = $this->getUser()->getUserIdentifier();
            $user = $repository->findOneBy(array('email' => $email));
            $liker->setUser($user);
            //set ressource 
            $ressourceid = $request->query->get('idressource');
            //search object forum
            $repository2 = $doctrine->getRepository(Ressource::class);
            $ressource= $repository2 -> findOneBy(array('id' => $ressourceid));
            $liker->setRessource($ressource);
            //liker set 1
            $liker->setLiker(1);

            $entityManager->persist($liker);
            $entityManager->flush();
        }
    }
    
    #[Route('/update/{id}', name: 'app_liker_update', methods: ['GET'])]
    public function update(Request $request ,Liker $liker, EntityManager $entityManager): Response
    {
        
        //set liker update
        $likerupdate = $request->query->get('update');
        //get user
        $user=$this->getUser();
        //verification of the owner of the post 
        if($user != $liker->getUser()){
            return $this->json("Vous n'êtes pas l'auteur de ce like ");
        }else{
            $liker->setLiker($likerupdate);
            $entityManager->persist($liker);
            $entityManager->flush();
            
        }

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
