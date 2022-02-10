<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CustomerVideoController extends AbstractController
{
    #[Route('/customer/video/visionner/{id}', name: 'customer_video_visionner')]
    public function visionner(int $id,
                                VideoRepository $videoRepository,
                                Request $request,
                                EntityManagerInterface $em): Response
    {
        $video = $videoRepository->find($id);

        if(!$video)
        {
            return $this->redirectToRoute("home");
        }

        $videos = $videoRepository->findAll();

        //Partie Commentaire

        //Je vais chercher tous les commentaires liés à la vidéo
        //Dans le but de les afficher dans la vue
        $comments = $video->getComments();

        //Je crée une instance de la classe Comment
        $comment = new Comment();

        //Je créé un formulaire CommentType et j'injecte dedans l'objet $comment
        $form = $this->createForm(CommentType::class,$comment);

        //Je check si le formulaire a bien été rempli
        $form->handleRequest($request);

        //Je verifie que le formulaire est soumis et valide
        if($form->isSubmitted() && $form->isValid())
        {
            //Je vais chercher l'utilisateur connecté
            $user = $this->getUser();

            //Je lie le commentaire à l'utilisateur connecté
            $comment->setUser($user);

            //Je lie le commentaire à la video
            $comment->setVideo($video);

            //Je persiste (préparation avant l'envoi en BDD) 
            $em->persist($comment);

            //J'envoie en bdd le commentaire
            $em->flush();

            //J'ajoute un message flash de succes
            $this->addFlash("success","Votre commentaire a bien été publié.");

            //Je redirige vers la page de la vidéo
            return $this->redirectToRoute("customer_video_visionner",['id'=> $id]);
        }


        return $this->render('customer_video/index.html.twig',[
            'video' => $video,
            'videos' => $videos,
            'comments' => $comments,
            'form' => $form->createView()
        ]);
    }
}
