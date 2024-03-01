<?php

namespace App\Controller;

use App\Entity\Ressource;
use App\Entity\User;
use App\Form\RessourceType;
use App\Repository\RessourceRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

use Symfony\Component\Validator\Constraints\File;

#[Route('/ressource')]
class RessourceController extends AbstractController
{
    #[Route('/', name: 'app_ressource_index', methods: ['GET'])]
    public function index(RessourceRepository $ressourceRepository): Response
    {
        return $this->render('ressource/index.html.twig', [
            'ressources' => $ressourceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ressource_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
        $ressource = new Ressource();
        $form = $this->createForm(RessourceType::class, $ressource);
        $form->handleRequest($request);
        //user 
        $email = $this->getUser()->getUserIdentifier();
        $repository = $doctrine->getRepository(User::class);
        $user = $repository->findOneBy(array('email' => $email));

        if ($form->isSubmitted() && $form->isValid()) {
            //image de presentation
            $imagesource = $form->get('image')->getData();

            if ($imagesource) {
                //changer le nom pour evité les doublon 
                $originalFilename = pathinfo($imagesource->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imagesource->guessExtension();
                //creer et déplacer l'image
                try {
                    //creer dosier user if d'ont exist
                    $userid = $user->getId(); 
                    $source = $this->getParameter("data_directory");
                    $url = "/data/".$userid."/ressourse";
                    if (file_exists( $url) == false){
                        mkdir($url, 0770, true );
                    }
                    
                    $imagesource->move(
                        $url,
                        $newFilename
                    );
                    $ressource->setImage($url."/".$newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }
            //fichier de tele chargement
            $fichiersource = $form->get('fichier')->getData();

            if ($fichiersource) {
                //changer le nom pour evité les doublons
                $originalFilename = pathinfo($fichiersource->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$fichiersource->guessExtension();
                //creer et déplacer l'image
                try {
                    //creer dosier user if d'ont exist
                    $userid = $user->getId(); 
                    $source = $this->getParameter("data_directory");
                    $url = "/data/".$userid."/ressourse";
                    if (file_exists( $url) == false){
                        mkdir($url, 0770, true );
                    }
                    
                    $imagesource->move(
                        $url,
                        $newFilename
                    );
                    
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }
            $ressource->setFichier($url."/".$newFilename);
            //date now
            $date = new DateTime('now');
            $ressource->setDatePublication($date);
            $ressource->setComptliker(0);
            //user 
            
            
            $ressource->setUser($user);
            $entityManager->persist($ressource);
            $entityManager->flush();

            return $this->redirectToRoute('app_ressource_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ressource/new.html.twig', [
            'ressource' => $ressource,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ressource_show', methods: ['GET'])]
    public function show(Ressource $ressource): Response
    {
        return $this->render('ressource/show.html.twig', [
            'ressource' => $ressource,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ressource_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ressource $ressource, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RessourceType::class, $ressource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ressource_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ressource/edit.html.twig', [
            'ressource' => $ressource,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ressource_delete', methods: ['POST'])]
    public function delete(Request $request, Ressource $ressource, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ressource->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ressource);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ressource_index', [], Response::HTTP_SEE_OTHER);
    }
}
