<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        //Je créé une instance de la classe User
        $user = new User();
        //Je créé mon formulaire avec comme modele  RegistrationFormType
        //J'envoie dans mon formulaire mon objet user, precedemment créé
        //Effectivement les champs rempli du formulaire vont hydrater l'objet User
        $form = $this->createForm(RegistrationFormType::class, $user);

        //La requete est analysé pour vérifier tout ce qui a été soumis dans le form
        //Et si il a été soumis
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Je recupere le password en clair qui vient du formulaire
            $plainPassword = $form->get('plainPassword')->getData();

            // J'encode le password
            $passwordHash = $userPasswordHasher->hashPassword(
                    $user,
                    $plainPassword
                )
            ;
            
            //Je set le password crypté (hashé) au User
            $user->setPassword($passwordHash);

            $entityManager->persist($user);
            $entityManager->flush();
            
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
