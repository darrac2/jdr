<?php

namespace App\Controller;

use App\Entity\Ressource;
use App\Entity\User;
use App\Form\UserType;
use App\Form\ProfileType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\File;

#[Route('/')]
class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('profile/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/profile/{id}/new', name: 'app_profile_image', methods: ['GET', 'POST'])]
    public function imageprofile(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager,User $user, SluggerInterface $slugger): Response
    {
        

        //user connecter
        $email = $this->getUser()->getUserIdentifier();
        $repository = $doctrine->getRepository(User::class);
        $user = $repository->findOneBy(array('email' => $email));
        //$user = new User();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imagesource = $form->get('profil_image')->getData();
            $originalFilename = pathinfo($imagesource->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$imagesource->guessExtension();
            //creer et déplacer l'image
            try {
                //creer dosier user if d'ont exist
                $userid = $user->getId(); 
                $source = $this->getParameter("data_directory");
                $url = $source."/".$userid."/profile";
                if (file_exists( $url) == false){
                    mkdir($url, 0770, true );
                }
                
                $imagesource->move(   
                    $url,
                    $newFilename
                );
                $user->setProfilImage($url."/".$newFilename);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            
            //$user->setProfilImage($url);
            //$entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/profile/{id}', name: 'app_user_profile', methods: ['GET'])]
    public function profil(User $user,ManagerRegistry $doctrine): Response
    {
        // ressource findBy User
        $ressouces = $doctrine->getRepository(Ressource::class)->findBy(["user" => $user]); 
        
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'ressources' => $ressouces,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user, ManagerRegistry $doctrine): Response
    {
        // ressource findBy User
        $ressouces = $doctrine->getRepository(Ressource::class)->findBy(["user" => $user]); 
        
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'ressources' => $ressouces,
        ]);
    }
    #[Route('/profile/image/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function imageupdate(Request $request, User $user, EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imagesource = $form->get('profil_image')->getData();
            $originalFilename = pathinfo($imagesource->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$imagesource->guessExtension();
            //creer et déplacer l'image
            try {
                //creer dosier user if d'ont exist
                $userid = $user->getId(); 
                $source = $this->getParameter("data_directory");
                $url = $source."/".$userid."/profile";
                if (file_exists( $url) == false){
                    mkdir($url, 0770, true );
                }
                
                $imagesource->move(   
                    $url,
                    $newFilename
                );
                $user->setProfilImage($url."/".$newFilename);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            
            $user->setProfilImage($url);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/profile/description/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
