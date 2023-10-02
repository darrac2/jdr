<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\ListAmis;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

//#[Route('/message', name: 'app_message')]
class MessageController extends Response 
{
    #[Route('/json', name: 'app_message_json',methods: ['POST'])]
    public function publish(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager, HubInterface $hub)
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
        $conversation->setMessage($message);
        $entityManager->persist($conversation);
         //set list amis
        $idlisteamis = $data['list_amisid'];
        $listamis = $doctrine->getRepository(ListAmis::class)->findOneBy(["id"=> $idamis]);
        //$entityManager->flush();
        //new message to amis
        /*$update = new Update(
            'https://localhost/message/'.$idamis,
            json_encode(['status' => 'OutOfStock'])
        );
        $hub->publish($update);*/

        // Keep some standard Symfony magic
        if (\function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        } elseif (\function_exists('litespeed_finish_request')) {
            litespeed_finish_request();
        } elseif (!\in_array(\PHP_SAPI, ['cli', 'phpdbg'], true)) {
            static::closeOutputBuffers(0, true);
        }

        return $this;
    }
}
