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
    public function new(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        
        
        $liker = new Liker();
        //set ressource 
        $ressourceid = $request->query->get('idressource');

        if ($ressourceid != null) {
            //user 
            $repository = $doctrine->getRepository(User::class);
            $email = $this->getUser()->getUserIdentifier();
            $user = $repository->findOneBy(array('email' => $email));
            $liker->setUser($user);
            //set ressource 
            $ressourceid = $request->query->get('idressource');
            //search object ressource
            $repository2 = $doctrine->getRepository(Ressource::class);
            $ressource= $repository2 -> findOneBy(array('id' => $ressourceid));
            //ressource ajouter count liker
            $ressourceliker = $ressource->getLiker();
            //find one by user and ressoure
            $check = $repository2->findOneBy(['user' => $user, 'ressource'=>$ressource]);
            if( $check != null ){
                $ressource->setLiker($ressourceliker +1 );
                $entityManager->persist($ressource);
                $liker->setRessource($ressource);
            //liker set 1
            $liker->setLiker(1);

            $entityManager->persist($liker);
            $entityManager->flush();
            $this->addFlash('success', 'Entity created successfully!');
            }

            
            return $this->redirectToRoute('app_home');

        }
        return $this->redirectToRoute('app_home');
    }
    
    #[Route('/update', name: 'app_liker_update', methods: ['GET'])]
    public function update(Request $request ,LikerRepository $likerRepository, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        
        //set liker update
        $likerupdate = $request->query->get('update');
        $idressource = $request->query->get('idressource');
        //get user
        $repository = $doctrine->getRepository(User::class);
        $email = $this->getUser()->getUserIdentifier();
        $user = $repository->findOneBy(array('email' => $email));
        //get ressource
        $repository2 = $doctrine->getRepository(Ressource::class);
        $ressource = $repository2->findOneBy(array('id' => $idressource));
        //get liker from user and ressource
        $liker = $likerRepository->findOneBy(['user'=>$user,'ressource' => $ressource]);
        //verification of the owner of the post 
        if($liker == null){
            return $$this->forward('app_liker_new',
            [
                'idressource'=>$idressource,
            ]
        );
        }else{
            if ($likerupdate != null){
                $liker->setLiker($likerupdate);
                $entityManager->persist($liker);
                $entityManager->flush();
            }
            return $this->redirectToRoute('app_home');
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
