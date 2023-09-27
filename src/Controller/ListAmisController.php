<?php

namespace App\Controller;


use App\Entity\ListAmis;
use App\Entity\User;
use App\Form\ListAmisType;
use App\Repository\ListAmisRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/list/amis')]
class ListAmisController extends AbstractController
{
    #[Route('/', name: 'app_list_amis_index', methods: ['GET', 'POST'])]
    public function index(ListAmisRepository $listAmisRepository,UserRepository $userRepository, ManagerRegistry $doctrine): Response
    {   
        //$repository = $doctrine->getRepository(User::class);
        //show userid + pseudo
        return $this->render('list_amis/index.html.twig', [
            'list_amis' => $listAmisRepository->findAll(),
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_list_amis_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
        $listAmi = new ListAmis();
        $form = $this->createForm(ListAmisType::class, $listAmi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //recherche
            $recherche = $form->get('recherche')->getData();
            $repository = $doctrine->getRepository(User::class);
            $amis = $repository->findOneBy(array('pseudo' => $recherche));
            if ($repository->findOneBy(array('pseudo' => $recherche)) == false){
                $this->addFlash('Invitation non envoyé utilisateur non trouvé', 'Ce pseudo est deja utilisé');
                return $this->render('list_amis/new.html.twig', [
                    'list_ami' => $listAmi,
                    'form' => $form,
                ]);
            }
            $listAmi->setIdAmis($amis);
            //demande
            $listAmi->setPending(0);
            //user 
            $repository = $doctrine->getRepository(User::class);
            $email = $this->getUser()->getUserIdentifier();
            $user = $repository->findOneBy(array('email' => $email));
            $listAmi->setIdUser($user);
            $entityManager->persist($listAmi);
            $entityManager->flush();

            return $this->redirectToRoute('app_list_amis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('list_amis/new.html.twig', [
            'list_ami' => $listAmi,
            'form' => $form,
        ]);
    }
    #[Route('/ajouter/{id}', name: 'app_list_amis_ajout', methods: ['GET', 'POST'])]
    public function ajout(User$amis, ManagerRegistry $doctrine, EntityManagerInterface $entityManager )
    {
        //creer new amis
        $listAmi = new ListAmis();
        //user
        $repository = $doctrine->getRepository(User::class);
        $email = $this->getUser()->getUserIdentifier();
        $user = $repository->findOneBy(array('email' => $email));
        $listAmi->setIdUser($user);
        // ajout amis
        $listAmi->setIdAmis($amis);
        //demande en attente 
        $listAmi->setPending(0);

        $entityManager->flush();
        //message alert envoie reussi

        //redirection
        return $this->redirectToRoute('app_list_amis_index', [], Response::HTTP_SEE_OTHER);

    }

    #[Route('/{id}', name: 'app_list_amis_accepter', methods: ['GET', 'POST'])]
    public function validation(ListAmis $listAmi, EntityManagerInterface $entityManager )
    {
        
        $listAmi->setPending(true);
        $entityManager->persist($listAmi);
        $entityManager->flush();
        //$idAmis = $listAmi->getIdUser();
        //$idUser = $listAmi->getIdAmis();
        // creer un check avant une nouvelle relation
        //creer new amis
        /*
        $listAmi2 = new ListAmis();
        //user
        $listAmi2->setIdUser($idUser);
        $listAmi2->setIdAmis($idAmis);
        $listAmi2->setPending(1);
        $entityManager->persist($listAmi2);
        $entityManager->flush();*/
        //creer conversation

        
        return $this->redirectToRoute('app_list_amis_index', [], Response::HTTP_SEE_OTHER);

    }
    
    

    #[Route('/{id}', name: 'app_list_amis_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, ListAmis $listAmi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$listAmi->getId(), $request->request->get('_token'))) {
            $entityManager->remove($listAmi);
            $entityManager->persist($listAmi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_list_amis_index', [], Response::HTTP_SEE_OTHER);
    }
}
