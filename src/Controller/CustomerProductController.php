<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerProductController extends AbstractController
{
    #[Route('/customer/category/{id}', name: 'customer_category')]
    public function index($id, CategoryRepository $categoryRepository): Response
    {
        //Je vais chercher ma catégorie grace au CategoryRepository 
        //Et grace a l'identifiant $id que je recois en parametre
        $category = $categoryRepository->find($id);

        //Si la catégorie existe pas on redirige vers la page d'accueil
        if(!$category)
        {
            return $this->redirectToRoute("home");
        }

        //si tout va bien , on affiche le rendu html du fichier twig et on envoie dans ce fichier twig
        //les variables nécessaires
        return $this->render('customer_product/category.html.twig', [
            'category' => $category
        ]);
    }

    #[Route('/customer/product/{id}', name: 'customer_product')]
    public function showProduct($id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);

        if(!$product)
        {
            return $this->redirectToRoute("home");
        }

        return $this->render('customer_product/product.html.twig',[
            'product' => $product
        ]);
    }


}
