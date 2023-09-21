<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    //push
    #[Route('/publish', name: 'app_publish')]
    public function publish(HubInterface $hub): Response
    {
        $update = new Update(
            'https://localhost/books/1',
            json_encode(['status' => 'message recu'])
        );

        $hub->publish($update);

        return new Response('published!');
    }
    //souscrire au push

}
