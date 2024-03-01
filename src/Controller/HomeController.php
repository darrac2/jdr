<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Entity\Conversation;
use App\Entity\ListAmis;
use App\Entity\User;
use App\Repository\ActualiteRepository;
use App\Repository\LikerRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\RessourceRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index( RessourceRepository $ressourceRepository, ActualiteRepository $actualiteRepository, LikerRepository $likerRepository): Response
    {
        
        
        return $this->render('home/index.html.twig', [
            'ressources' => $ressourceRepository->findAll(),
            'actualites' => $actualiteRepository->findAll(),
            'controller_name' => 'HomeController',
            'liker' => $likerRepository->findAll(),
        ]);
    }
    #[Route('/profile', name: 'app_profile')]
    public function profile( RessourceRepository $ressourceRepository ,UserRepository $userRepository): Response
    {
 
        return $this->render('home/profile.html.twig', [
            'users' => $userRepository->findAll(),
            'ressources' => $ressourceRepository->findAll(),
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/message', name: 'app_message',methods: ['POST'])]
    public function publish(Request $request,ManagerRegistry $doctrine, EntityManagerInterface $entityManager, HubInterface $hub)
    {
       //recuperer la requete json
       $data = json_decode($request->getContent(), true);
       
        //creer le nouveau message pour l'historique
        $conversation = new Conversation();
        $iduser = $data['iduser'];
        $user = $doctrine->getRepository(User::class)->findOneBy(["id"=> $iduser]);
        $idamis = $data['idamis'];
        $amis = $doctrine->getRepository(User::class)->findOneBy(["id"=> $idamis]);
        $message = $data['message'];
        //user   
        $conversation->setUserfirst($user);
        $conversation->setUsersecond($amis);
        $date = new DateTime('now');
        $conversation->setDate($date);
        //set list amis
        $idlisteamis = $data['list_amisid'];
        $listamis = $doctrine->getRepository(ListAmis::class)->findOneBy(["id"=> $idlisteamis]);
        $conversation->setListAmis($listamis);
        $conversation->setMessage($message);
        $entityManager->persist($conversation);
        $entityManager->flush();

        $jsonMessage = json_encode([
            'message' => $message,
            "idListamis" => $listamis,
        ]);

        //new message to amis
        $update = new Update(
            sprintf('https://localhost/message/%s',
                $idamis),
                $jsonMessage
        );
        $hub->publish($update);

        return new JsonResponse(
            $jsonMessage,
            Response::HTTP_OK,
            [],
            true
        );
    }
}
