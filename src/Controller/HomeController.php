<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Form\ConversationType;
use App\Repository\ConversationRepository;
use App\Repository\ListAmisRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use DateTime;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ListAmisRepository $listAmisRepository ,UserRepository $userRepository,ConversationRepository $conversationRepository, ManagerRegistry $doctrine): Response
    {
        return $this->render('home/index.html.twig', [
            'conversations' => $conversationRepository->findAll(),
            'list_amis' => $listAmisRepository->findAll(),
            'users' => $userRepository->findAll(),
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/message', name: 'app_message')]
    public function publish(Request $request,ManagerRegistry $doctrine, Conversation $conversation, HubInterface $hub, $amis): Response
    {
        //creer le nouveau message pour l'historique
        $conversation = new Conversation();
        
        //user
        $repository = $doctrine->getRepository(User::class);
        $email = $this->getUser()->getUserIdentifier();
        $user = $repository->findOneBy(array('email' => $email));
        $conversation->setUserfirst($user);
        $conversation->setUsersecond($amis);
        $date = new DateTime('now');
        $conversation->setDate($date);
        //new message
        $update = new Update(
            'https://localhost/message/1',
            json_encode(['status' => 'OutOfStock'])
        );

        $hub->publish($update);
    }
}
