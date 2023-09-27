<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ConversationRepository;
use App\Repository\ListAmisRepository;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ListAmisRepository $listAmisRepository,MessageRepository $messageRepository ,UserRepository $userRepository,ConversationRepository $conversationRepository, ManagerRegistry $doctrine): Response
    {
        //find by user connecter
        //user
        $repository = $doctrine->getRepository(User::class);
        $email = $this->getUser()->getUserIdentifier();
        $user = $repository->findOneBy(array('email' => $email));
        $reposotory1 = $listAmisRepository->findBy(['idUser' => $user]);
        $repository2 = $listAmisRepository->findBy(['idAmis' => $user]);
        $listAmisRepository = $reposotory1 + $repository2;
        //conversation
        $conversationRepository1 = $conversationRepository->findBy(["userfirst" => $user]);
        $conversationRepository2 = $conversationRepository->findBy(["UserSecond" => $user]);
        $conversationRepository = $conversationRepository1 + $conversationRepository2;
        //message
        //$messageRepository = $messageRepository->findBy();
        return $this->render('home/index.html.twig', [
            'conversations' => $conversationRepository,
            'list_amis' => $listAmisRepository,
            'users' => $userRepository->findAll(),
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/message', name: 'app_message')]
    public function publish(HubInterface $hub): Response
    {
        //form
        
        //new message
        $update = new Update(
            'https://localhost/message/1',
            json_encode(['status' => 'OutOfStock'])
        );

        $hub->publish($update);

        return new Response('published!');
    }
}
